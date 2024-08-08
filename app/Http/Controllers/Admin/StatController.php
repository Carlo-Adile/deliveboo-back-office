<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;

class StatController extends Controller
{
	/**
		* Display a listing of the resource.
		*/
	public function index(Request $request)
	{
		/* Accesso ai dati del ristorante corrente; reindirizza alla registrazione se non esiste */
		$currentUser = Auth::id();
		$currentRestaurant = Restaurant::where('user_id', $currentUser)->first();
		if (!$currentRestaurant) {
			return redirect()->route('admin.dashboard')->with('error', 'Ristorante non trovato.');
		}

		/* filtro per periodi */
		$selectedPeriod = $request->input('period', 'last12');
		$endDate = now();
		$startDate = match ($selectedPeriod) {
			'last12' => now()->subMonths(12),
			'last13-24' => now()->subMonths(24)->startOfMonth(),
			'last25-36' => now()->subMonths(36)->startOfMonth(),
			default => now()->subMonths(12),
		};

		/* query chart 1 con total orders e somma del venduto */
		$orders = DB::table('orders')
			->select(
				DB::raw('MONTH(date) as month'),
				DB::raw('YEAR(date) as year'),
				DB::raw('COUNT(id) as order_count'),
				DB::raw('SUM(total_price) as total_sum')
			)
			->where('restaurant_id', $currentRestaurant->id)
			->whereBetween('date', [$startDate, $endDate])
			->groupBy(DB::raw('YEAR(date), MONTH(date)'))
			->get();

		/* inizializzazione variabili per chart 1 */
		$labels = [];
		$orderCounts = [];
		$totalSums = [];

		/* Inizializzazione dell'array associativo per i mesi */
		$periodMonths = [];
		for ($i = 0; $i < 12; $i++) {
			$month = (int) $startDate->copy()->addMonths($i)->format('m');
			$year = (int) $startDate->copy()->addMonths($i)->format('Y');
			$periodMonths["$year-$month"] = [
				'month' => $month,
				'year' => $year,
				'order_count' => 0,
				'total_sum' => 0.0,
			];
		}

		/* dalla query alle variabili + mesi */
		$months = [
			1 => 'Gennaio',
			2 => 'Febbraio',
			3 => 'Marzo',
			4 => 'Aprile',
			5 => 'Maggio',
			6 => 'Giugno',
			7 => 'Luglio',
			8 => 'Agosto',
			9 => 'Settembre',
			10 => 'Ottobre',
			11 => 'Novembre',
			12 => 'Dicembre',
		];
		foreach ($orders as $order) {
			$key = "$order->year-$order->month";
			if (isset($periodMonths[$key])) {
				$periodMonths[$key]['order_count'] = $order->order_count;
				$periodMonths[$key]['total_sum'] = $order->total_sum;
			}
		}
		foreach ($periodMonths as $period) {
			$labels[] = $months[$period['month']] . ' ' . $period['year'];
			$orderCounts[] = $period['order_count'];
			$totalSums[] = $period['total_sum'];
		}

		/* query chart 2 dish quantity */
		$data = DB::table('dish_order')
			->select('dish_name', DB::raw('SUM(dish_quantity) AS total_quantity'))
			->join('orders', 'dish_order.order_id', '=', 'orders.id')
			->where('orders.restaurant_id', $currentRestaurant->id)
			->whereBetween('orders.date', [$startDate, $endDate])
			->groupBy('dish_name')
			->orderByDesc('total_quantity')
			->get();

		/* variabili bars per chart 2 */
		$barLabels = $data->pluck('dish_name')->toArray(); // Etichette delle barre
		$barQuantities = $data->pluck('total_quantity')->toArray();

		/* chart 1 */
		$chartjs = app()->chartjs
			->name('ordersChart')
			->type('bar')
			->labels($labels)
			->datasets([
				[
					"label" => "Somma Totale degli Ordini in €",
					'backgroundColor' => 'rgba(255, 99, 132, 0.6)',
					'borderColor' => 'rgba(255, 99, 132, 1)',
					"data" => $totalSums,
					"order" => 1,
					"yAxisID" => "totalAxis",
				],
				[
					"label" => "Numero di Ordini ricevuti",
					'backgroundColor' => 'rgba(75, 192, 192, 0.6)',
					'borderColor' => 'rgba(75, 192, 192, 1)',
					"data" => $orderCounts,
					"order" => 2,
					"yAxisID" => "ordersAxis",
				]
			])
			->options([
				'scales' => [
					'ordersAxis' => [
						'type' => 'linear',
						'position' => 'right',
						'ticks' => [
							'beginAtZero' => true,
							'stepSize' => 2
						],
						'grid' => [
							'display' => false
						]
					],
					'totalAxis' => [
						'type' => 'linear',
						'position' => 'left',
						'ticks' => [
							'beginAtZero' => true,
							'stepSize' => 200
						],
					],
				],
			]);

		/* chart 2 */
		$chartjs2 = app()->chartjs
			->name('barChart')
			->type('bar')
			->labels($barLabels)
			->datasets([
				[
					'label' => 'Quantità ordinate',
					'backgroundColor' => '#36A2EB',
					'data' => $barQuantities,
				]
			])
			->options([
				'scales' => [
					'y' => [
						'stacked' => true,
					],
					'x' => [
						'stacked' => true,
						'beginAtZero' => true,
					],
				],
				'indexAxis' => 'y',
				/* 'barThickness' => 30 */
			]);

		return view('admin.stats.index', compact('chartjs', 'chartjs2', 'selectedPeriod'));
	}
}

