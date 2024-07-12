<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\IngredientRecipe;
use App\Models\Recipe;
use App\Models\Unit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use DiDom\Document as diDomDocument;

class SarashpazCrawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sarashpaz-crawler {limit}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $limit = $this->argument('limit');

        for ($i = 1; $i <= $limit; $i++) {
            $response = Http::get("https://sarashpazpapion.com/recipe/$i");
            $doc = new diDomDocument($response->body());

            $recipe = new Recipe();
            $recipe->title = $doc->first("h2.title-seo")->text();
            $recipe->people = (int)$this->persianToEnglishNumbers($doc->first("div.ing-h > div.number > span.num")->text());
            $recipe->image = $doc->first("meta[property=og:image]")->getAttribute("content");

            $schema = json_decode($doc->first("script[type=application/ld+json]")->text());
            $recipe->prep_time = $this->convertToMinutes($schema->prepTime);
            $recipe->cook_time = $this->convertToMinutes($schema->cookTime);

            $instructions = [];
            foreach ($doc->find("div.step-t > div.step-text") as $instruction) {
                $instructions[] = $this->cleanText($instruction->text());
            }

            $notes = [];
            foreach ($doc->find("div.other-notes-t") as $note) {
                $n = $this->cleanText($note->text());
                if (!empty($n)) {
                    $notes[] = $this->cleanText($n);
                }
            }

            $recipe->notes = $notes;
            $recipe->instructions = $instructions;

            $category = Category::query()->firstOrCreate(["name" => $this->cleanText($schema->recipeCategory)]);
            $recipe->category()->associate($category);

            $recipe->save();

            foreach ($doc->find("div.ing-e") as $ingredient) {
                $ingredientName = $this->cleanText(str_replace("\n","",$ingredient->first("div.ing-title")->text()));
                $ingredientModel = Ingredient::query()->firstOrCreate(["title" => $ingredientName]);
                $unitInfo = $this->splitUnit($this->persianToEnglishNumbers($ingredient->first("div.ing-unit")->text()));
                $unit = Unit::query()->firstOrCreate(['name' => $unitInfo['unit']]);
                if (IngredientRecipe::query()->where(['recipe_id' => $recipe->id , 'ingredient_id' => $ingredientModel->id])->first() == null){
                    IngredientRecipe::query()->create(
                        [
                            'recipe_id' => $recipe->id,
                            'ingredient_id' => $ingredientModel->id,
                            'unit_id' => $unit->id,
                            'amount' => $unitInfo['amount'],
                        ]
                    );
                }
            }
        }
    }

    function convertToMinutes($duration)
    {
        // Match the duration pattern
        preg_match('/PT(\d+H)?(\d+M)?/', $duration, $matches);

        // Initialize hours and minutes
        $hours = 0;
        $minutes = 0;

        // Check and set the hours if present
        if (isset($matches[1])) {
            $hours = (int)$this->cleanText($matches[1], 'H');
        }

        // Check and set the minutes if present
        if (isset($matches[2])) {
            $minutes = (int)$this->cleanText($matches[2], 'M');
        }

        // Convert hours to minutes and add to minutes
        return ($hours * 60) + $minutes;
    }

    function splitUnit($text)
    {
        // Regular expression to match the first number and the rest of the text
        preg_match('/(\d*)\s*(.*)/', $text, $matches);

        // Extract the amount and unit
        $amount = !empty($matches[1]) ? $matches[1] : 0;
        $unit = $matches[2];

        return ['amount' => (int)$amount, 'unit' => $unit];
    }

    function persianToEnglishNumbers($text)
    {
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($persianNumbers, $englishNumbers, $text);
    }

    function removeExtraSpaces($string) {
        // Use regular expression to replace multiple spaces with a single space
        return preg_replace('/\s+/', ' ', $string);
    }

    function cleanText($text)
    {
        return trim($this->removeExtraSpaces(str_replace("\n" , "",$this->persianToEnglishNumbers($text))));
    }

}
