<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Models\Restaurant;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $orders = [
            ['name' => 'Antonio', 'lastname' => 'Di Francesco'],
            ['name' => 'Francesco', 'lastname' => 'Sabino'],
            ['name' => 'Michele', 'lastname' => 'Maggiore'],
            ['name' => 'Luca', 'lastname' => 'Bianchi'],
            ['name' => 'Giulia', 'lastname' => 'Rossi'],
            ['name' => 'Marco', 'lastname' => 'Verdi'],
            ['name' => 'Anna', 'lastname' => 'Neri'],
            ['name' => 'Paolo', 'lastname' => 'Gialli'],
            ['name' => 'Giorgio', 'lastname' => 'Russo'],
            ['name' => 'Laura', 'lastname' => 'Bianco'],
            ['name' => 'Andrea', 'lastname' => 'Ferrari'],
            ['name' => 'Elena', 'lastname' => 'Moretti'],
            ['name' => 'Giovanni', 'lastname' => 'Greco'],
            ['name' => 'Maria', 'lastname' => 'Esposito'],
            ['name' => 'Simone', 'lastname' => 'Romano'],
            ['name' => 'Cristina', 'lastname' => 'Martini'],
            ['name' => 'Davide', 'lastname' => 'Barbieri'],
            ['name' => 'Valentina', 'lastname' => 'Gatti'],
            ['name' => 'Alessandro', 'lastname' => 'Costa'],
            ['name' => 'Serena', 'lastname' => 'Fontana'],
            ['name' => 'Matteo', 'lastname' => 'Ricci'],
            ['name' => 'Silvia', 'lastname' => 'Marini'],
            ['name' => 'Lorenzo', 'lastname' => 'Conte'],
            ['name' => 'Chiara', 'lastname' => 'Rinaldi'],
            ['name' => 'Federico', 'lastname' => 'Mancini'],
            ['name' => 'Roberta', 'lastname' => 'Vitale'],
            ['name' => 'Enrico', 'lastname' => 'Ruggiero'],
            ['name' => 'Francesca', 'lastname' => 'Basile'],
            ['name' => 'Stefano', 'lastname' => 'Colombo'],
            ['name' => 'Giulia', 'lastname' => 'Rinaldi'],
            ['name' => 'Fabio', 'lastname' => 'Bianchi'],
            ['name' => 'Lucia', 'lastname' => 'De Luca'],
            ['name' => 'Pietro', 'lastname' => 'Giordano'],
            ['name' => 'Carla', 'lastname' => 'Ferraro'],
            ['name' => 'Giorgia', 'lastname' => 'Lombardi'],
            ['name' => 'Nicola', 'lastname' => 'Ferri'],
            ['name' => 'Alessia', 'lastname' => 'Leone'],
            ['name' => 'Roberto', 'lastname' => 'Grimaldi'],
            ['name' => 'Martina', 'lastname' => 'Santoro'],
            ['name' => 'Daniele', 'lastname' => 'Orlando'],
            ['name' => 'Giada', 'lastname' => 'Marino'],
            ['name' => 'Riccardo', 'lastname' => 'Guerra'],
            ['name' => 'Veronica', 'lastname' => 'Pellegrini'],
            ['name' => 'Giuseppe', 'lastname' => 'Rizzo'],
            ['name' => 'Elisabetta', 'lastname' => 'D’Amico'],
            ['name' => 'Tommaso', 'lastname' => 'Serra'],
            ['name' => 'Sofia', 'lastname' => 'Ferrara'],
            ['name' => 'Claudio', 'lastname' => 'Longo'],
            ['name' => 'Gabriele', 'lastname' => 'Monti'],
            ['name' => 'Ilaria', 'lastname' => 'Gentile']
        ];
        //recupero tutte le istanze dei ristoranti
        $restaurants = Restaurant::all();

        foreach ($restaurants as $restaurant) {
            foreach ($orders as $orderData) {
                $order = new Order();
                $order->restaurant_id = $restaurant->id;
                $order->customer_name = $orderData['name'];
                $order->customer_lastname = $orderData['lastname'];
                $order->customer_phone_number = $faker->phoneNumber;
                $order->customer_address = $faker->streetAddress;
                $order->customer_email = $faker->safeEmail;
                $order->total_price = $faker->randomFloat($nbMaxDecimals = 3, $min = 9.99, $max = 399.99);
                $order->date = $faker->dateTimeBetween('2021-06-01', 'now')->format('Y-m-d H:i:s'); //grazie a faker indico che la data deve essere casuale ed inserita dal primo gennaio 2022 ad oggi con formato date time
                //manca status perchè viene messo di default
                $order->save();
            }
        }
    }
}
