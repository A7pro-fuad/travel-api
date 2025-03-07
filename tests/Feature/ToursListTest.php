<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToursListTest extends TestCase
{
    use RefreshDatabase;

    public function test_tours_list_by_travel_slug_returns_correct_tours(): void
    {
        $travel = Travel::factory()->create();
        $tour = Tour::factory()->create(['travel_id' => $travel->id]);
        $response = $this->get('/api/v1/travels/' . $travel->slug . '/tours');
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['id' => $tour->id]);
    }

    public function test_tours_price_is_shown_correctly(): void
    {
        $travel = Travel::factory()->create();
        Tour::factory()->create([
            'travel_id' => $travel->id,
            'price' => 123.45,
        ]);

        $response = $this->get('/api/v1/travels/' . $travel->slug . '/tours');
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['price' => '123.45']);
    }

    public function test_tours_list_returns_pagination(): void
    {
        // $toursPerPage = config('app.paginationPerPage.tours');
        $travel = Travel::factory()->create();
        // Tour::factory($toursPerPage + 1)->create(['travel_id' => $travel->id]);
        Tour::factory(16)->create(['travel_id' => $travel->id]);

        $response = $this->get('/api/v1/travels/' . $travel->slug . '/tours');
        $response->assertStatus(200);
        // $response->assertJsonCount(1, 'data');
        $response->assertJsonCount(15, 'data');
        // $response->assertJsonPath(['meta.current_page'], 1);
        $response->assertJsonPath('meta.last_page', 2);
    }

    public function test_tours_list_sorts_by_starting_date_correctly(): void
    {
        $travel = Travel::factory()->create();
        $laterTour = Tour::factory(16)->create(
            [
                'travel_id' => $travel->id,
                'starting_date' => now()->addDays(2),
                'ending_date' => now()->addDays(3),
            ]
        );
        $earlierTour
            = Tour::factory()->create(
                [
                    'travel_id' => $travel->id,
                    'starting_date' => now(),
                    'ending_date' => now()->addDays(1),
                ]
            );
        $response = $this->get('/api/v1/travels/' . $travel->slug . '/tours');
        $response->assertStatus(200);
        $response->assertJsonPath('data.0.id', $earlierTour->id);
        $response->assertJsonPath('data.1.id', $laterTour->id);
    }

    public function test_tours_list_sorts_by_price_correctrly(): void
    {
        // $toursPerPage = config('app.paginationPerPage.tours');
        $travel = Travel::factory()->create();
        // Tour::factory($toursPerPage + 1)->create(['travel_id' => $travel->id]);
        $expensiveTour = Tour::factory(16)->create([
            'travel_id' => $travel->id,
            'price' => 123.45,
        ]);
        $cheapLaterTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'price' => 12.34,
            'starting_date' => now()->addDays(2),
            'ending_date' => now()->addDays(3),
        ]);

        $cheapEarlierTour
            = Tour::factory()->create([
                'travel_id' => $travel->id,
                'price' => 12.34,
                'starting_date' => now(),
                'ending_date' => now()->addDays(1),
            ]);

        $response = $this->get('/api/v1/travels/' . $travel->slug . '/tours?sortBy=price&sortOrder=asc');

        $response->assertStatus(200);
        // $response->assertJsonCount(1, 'data');

        $response->assertJsonPath('data.0.id', $cheapEarlierTour->id);
        $response->assertJsonPath('data.1.id', $cheapLaterTour->id);
        $response->assertJsonPath('data.2.id', $expensiveTour->id);
    }

    public function test_tours_list_filters_by_price_correctly(): void
    {
        $travel = Travel::factory()->create();
        $expensiveTour = Tour::factory()->create(['travel_id' => $travel->id, 'price' => 200]);
        $cheapTour = Tour::factory()->create(['travel_id' => $travel->id, 'price' => 100]);

        $endpoint = '/api/v1/travels/' . $travel->slug . '/tours';

        $response = $this->get($endpoint . '?priceFrom=100');
        $response->assertJsonCount(2, 'data');
        $response->assertJsonFragment(['id' => $cheapTour->id]);
        $response->assertJsonFragment(['id' => $expensiveTour->id]);

        $response = $this->get($endpoint . '?priceFrom=150');
        $response->assertJsonCount(1, 'data');
        $response->assertJsonMissing(['id' => $cheapTour->id]);
        $response->assertJsonFragment(['id' => $expensiveTour->id]);

        $response = $this->get($endpoint . '?priceFrom=250');
        $response->assertJsonCount(0, 'data');

        $response = $this->get($endpoint . '?priceTo=200');
        $response->assertJsonCount(2, 'data');
        $response->assertJsonFragment(['id' => $cheapTour->id]);
        $response->assertJsonFragment(['id' => $expensiveTour->id]);

        $response = $this->get($endpoint . '?priceTo=150');
        $response->assertJsonCount(1, 'data');
        $response->assertJsonMissing(['id' => $expensiveTour->id]);
        $response->assertJsonFragment(['id' => $cheapTour->id]);

        $response = $this->get($endpoint . '?priceTo=50');
        $response->assertJsonCount(0, 'data');

        $response = $this->get($endpoint . '?priceFrom=150&priceTo=250');
        $response->assertJsonCount(1, 'data');
        $response->assertJsonMissing(['id' => $cheapTour->id]);
        $response->assertJsonFragment(['id' => $expensiveTour->id]);
    }

    public function test_tours_list_filters_by_starting_date_correctly(): void
    {

        $travel = Travel::factory()->create();
        $laterTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'starting_date' => now()->subDays(2),
            'ending_date' => now()->subDays(3),
        ]);
        $earlierTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'starting_date' => now(),
            'ending_date' => now()->addDays(1),
        ]);

        $endpoint = 'api/v1/travels/' . $travel->slug . '/tours';

        $response = $this->get($endpoint . '?dateFrom=' . now());
        $response->assertJsonCount(2, 'data');
        $response->assertJsonFragment(['id' => $earlierTour->id]);
        $response->assertJsonFragment(['id' => $laterTour->id]);

        $response = $this->get($endpoint . '?dateFrom=' . now()->addDay());
        $response->assertJsonCount(1, 'data');
        $response->assertJsonMissing(['id' => $earlierTour->id]);
        $response->assertJsonFragment(['id' => $laterTour->id]);

        $response = $this->get($endpoint . '?dateFrom=' . now()->subDays(5));
        $response->assertJsonCount(0, 'data');

        $response = $this->get($endpoint . '?dateTo=' . now()->addDays(5));
        $response->assertJsonCount(2, 'data');
        $response->assertJsonFragment(['id' => $earlierTour->id]);
        $response->assertJsonFragment(['id' => $laterTour->id]);

        $response = $this->get($endpoint . '?dateTo=' . now()->addDay());
        $response->assertJsonCount(1, 'data');
        $response->assertJsonMissing(['id' => $laterTour->id]);
        $response->assertJsonFragment(['id' => $earlierTour->id]);

        $response = $this->get($endpoint . '?dateTo=' . now()->subDay());
        $response->assertJsonCount(0, 'data');

        $response = $this->get($endpoint . '?dateFrom=' . now()->addDay() . '&dateTo=' . now()->addDays(5));
        $response->assertJsonCount(1, 'data');
        $response->assertJsonMissing(['id' => $earlierTour->id]);
        $response->assertJsonFragment(['id' => $laterTour->id]);
    }
}
