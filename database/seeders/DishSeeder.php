<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dish;
use App\Models\Restaurant;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $dishes = [
            ['name' => 'Pizza Margherita', 'price' => 8.50, 'image' => 'uploads/pizza-margherita.jpg', 'description' => 'Una deliziosa combinazione di impasto sottile, salsa di pomodoro, mozzarella fresca e foglie di basilico.'],

            ['name' => 'Spaghetti alla Carbonara', 'price' => 12.75, 'image' => 'uploads/spaghetti-carbonara.jpg', 'description' => 'Un piatto tradizionale romano fatto con spaghetti al dente, guanciale croccante, uova cremose, pecorino romano e una spolverata di pepe nero. '],

            ['name' => 'Insalata Caprese', 'price' => 9.25, 'image' => 'uploads/insalata-caprese.jpg', 'description' => 'Una fresca combinazione di pomodori maturi, mozzarella di bufala, basilico fresco e un filo di olio extravergine di oliva. Questo piatto è perfetto per antipasti o pranzi leggeri.'],

            ['name' => 'Lasagna alla Bolognese', 'price' => 14.99, 'image' => 'uploads/lasagna-bolognese.jpg', 'description' => 'Strati di pasta fresca all\'uovo, ragù di carne alla bolognese, besciamella vellutata e parmigiano grattugiato. Una ricetta ricca e saporita, simbolo della tradizione emiliana, ideale per chi cerca un piatto sostanzioso e avvolgente'],

            ['name' => 'Filetto di Salmone', 'price' => 18.50, 'image' => 'uploads/filetto-salmone.jpg', 'description' => 'Filetto di salmone fresco, cotto alla perfezione e servito con un tocco di limone e un contorno di verdure di stagione. Un piatto leggero e nutriente, esaltato dalla delicatezza del pesce e dalla freschezza degli ingredienti.'],

            ['name' => 'Bistecca Fiorentina', 'price' => 25.00, 'image' => 'uploads/bistecca-fiorentina.jpg', 'description' => 'Un taglio pregiato di carne di manzo, cotto alla griglia e servito al sangue per esaltarne il sapore autentico. Condita con un filo di olio extravergine di oliva e una spolverata di sale grosso.'],

            ['name' => 'Risotto ai Funghi Porcini', 'price' => 16.50, 'image' => 'uploads/risotto-porcini.jpg', 'description' => 'Riso Carnaroli mantecato con funghi porcini freschi, burro e parmigiano reggiano. Un piatto cremoso e aromatico, che celebra i sapori intensi dei boschi italiani.'],

            ['name' => 'Tortellini in Brodo', 'price' => 10.99, 'image' => 'uploads/tortellini-brodo.jpg', 'description' => 'Tortellini fatti a mano, ripieni di carne e serviti in un brodo caldo e saporito. Un classico della tradizione emiliana, che unisce la delicatezza della pasta fresca alla ricchezza del brodo.'],

            ['name' => 'Gnocchi al Pesto', 'price' => 11.25, 'image' => 'uploads/gnocchi-pesto.jpg', 'description' => 'Gnocchi di patate morbidi e leggeri, conditi con un aromatico pesto genovese fatto con basilico fresco, pinoli, aglio, parmigiano e olio extravergine di oliva.'],

            ['name' => 'Tiramisù', 'price' => 7.99, 'image' => 'uploads/tiramisu.jpg', 'description' => 'Un dolce italiano classico composto da strati di savoiardi imbevuti nel caffè, alternati a una crema di mascarpone leggera e spolverata di cacao amaro. Deliziosamente equilibrato tra dolcezza e intensità, è un finale perfetto per ogni pasto.'],

        ];

        $restaurants = Restaurant::all();

        foreach ($restaurants as $restaurant) {
            foreach ($dishes as $dishData) {
                $dish = new Dish();
                $dish->restaurant_id = $restaurant->id;
                $dish->name = $dishData['name'];
                $dish->price = $dishData['price'];
                $dish->image = $dishData['image'];
                $dish->slug = Str::of($dish->name)->slug('-');
                $dish->description = $dishData['description'];
                $dish->visible = true;
                $dish->save();
            }
        }
    }
}
