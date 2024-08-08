<?php

namespace App\Http\Controllers\API\Order;

use Braintree\Gateway;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Models\Dish;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewLeadMessage;

class OrderController extends Controller
{

    public function generate(Request $request, Gateway $gateway)
    {
        $token = $gateway->clientToken()->generate();

        $data = [
            'success' => true,
            'token' => $token
        ];

        return response()->json($data, 200);
    }


    public function makePayment(OrderRequest $request, Gateway $gateway)
    {

        $allDishes = $request->allDishes;
        //mi recupero tutti i piatti ordinati
        $order = $request->order;
        //mi recupero l'id del ristorante
        $restaurant_id = $request->restaurantId;
        //salvo l'istanza del ristorante associata all'id
        $singleRestaurant = Restaurant::find($restaurant_id);


        //0) recuperare l'id del ristorante e dei singoli piatti e controllare che quei piatti esistano per quel singolo ristorante, se si continuo, altrimenti ritorni erorre
        //1)recuperare per ogni id inserito nell'array $request->order il prezzo dal db
        //2)moltiplicare per ogni prodotto il prezzo recuperato precedentemente dal DB e la quantità che abbiamo in $request->order con la chiave quantità
        //3) creare una variabile sum, che somma il prezzo di ogni prodotto già moltiplicato per la quantità
        //4) modificare l'amount, perchè non deve ricevere più order, ma adesso deve ricevere il prezzo totale dell'ordine(controllare la valuta)
        //5)creare un form lato user che indichi il nome, il cognome, l'indirizzo,l'email,numero telefono,prezzo totale(che dobbiamo calcolare e salvare non in fase di salvataggio),data(recuperandola dal sistema)

        $totalPrice = null;

        foreach ($order as $singleDish) {
            $dish = Dish::find($singleDish['id']);
            if ($dish && $dish->restaurant_id == $request->restaurantId) {
                $totalPrice += $dish->price * $singleDish['quantity'];
            } else {
                $data = [
                    'success' => false,
                    'message' => "Prodotto non trovato o non appartiene al ristorante specificato!!",
                    'order' => $order,
                    'paymentMethodNonce' => $request->token,
                    'all' => $request->all(),

                ];
                return response()->json($data, 400);
            }
        }
        //arrivo qui solo se non c'è stato un return, questo significa che la validazione e il foreach sui piatti sono andati a buon fine
        //a questo punto creo un'istanza nella tabella pivot, per salvare l'ordine, prima di inviare un response

        date_default_timezone_set('Europe/Rome');
        $newOrder = new Order();
        $newOrder->restaurant_id = $restaurant_id;
        $newOrder->customer_name = $request['customerName'];
        $newOrder->customer_lastname = $request['customerLastName'];
        $newOrder->customer_phone_number = $request['customerPhoneNumber'];
        $newOrder->customer_address = $request['customerAddress'];
        $newOrder->customer_email = $request['customerEmail'];
        $newOrder->total_price = $totalPrice;
        $newOrder->date = date('Y-m-d H:i:s');
        //manca status perchè viene messo di default
        $newOrder->save();

        //vado a creare la nuova email con il costruttore sia per l'utente che per il ristoratore
        Mail::to($request->customerEmail)->send(new NewLeadMessage($allDishes, $newOrder, true));

        Mail::to($singleRestaurant->user->email)->send(new NewLeadMessage($order, $singleRestaurant, false));



        //solo dopo aver creato l'ordine, posso fare l'attach con i singoli piatti
        foreach ($order as $dishOrder) {
            $dishControl = Dish::find($dishOrder['id']);
            $newOrder->dishes()->attach($dishOrder['id'], [
                'dish_name' => $dishControl->name,
                'dish_quantity' => $dishOrder['quantity'],
                'dish_price' => $dishControl->price,
            ]);
        }

        $result = $gateway->transaction()->sale([
            'amount' => $totalPrice, // qui devo inserire il totale dell'ordine
            'paymentMethodNonce' => $request->token,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {

            // se la transazione è avvenuta con successo, allora creiamo un'istanza di Oreder per salvare i dati

            $data = [
                'success' => true,
                'message' => "Transazione eseguita con Successo!",
                'order' => $order,
                'restaurant_id' => $restaurant_id,
                'singleRestaurant' => $singleRestaurant,
                'paymentMethodNonce' => $request->token,
                'all' => $request->all(),
                'totalPrice' => $totalPrice,
                'result' => $result,
                'allDishes' => $allDishes,
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'success' => false,
                'message' => "Transazione Fallita!!",
                'order' => $order,
                'paymentMethodNonce' => $request->token,
                'all' => $request->all(),
                'totalPrice' => $totalPrice,
                'result' => $result,
                // debugg comment 
                'allDishes' => $allDishes,
            ];
            return response()->json($data, 401);
        }
    }
}
