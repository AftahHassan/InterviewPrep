<?php

namespace App\Http\Controllers;

use App\Models\Concept;
use App\Models\GeneratedQuestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;

class GeneratedQuestionController extends Controller
{
    public function store(Concept $concept): RedirectResponse
    {
        abort_if($concept->domain->user_id !== auth()->id(), 403);

        $prompt = "Tu es un expert en entretiens techniques pour développeurs web.\n"
            . "Génère exactement 5 questions d'entretien techniques sur ce concept.\n"
            . "Concept : {$concept->title}\n"
            . "Explication : {$concept->explanation}\n"
            . "Niveau : {$concept->difficultyLabel}\n"
            . "Réponds UNIQUEMENT avec un tableau JSON de 5 strings.\n"
            . "Exemple : [\"Question 1 ?\", \"Question 2 ?\", \"Question 3 ?\", \"Question 4 ?\", \"Question 5 ?\"]\n"
            . "Rien d'autre. Pas d'introduction. Pas d'explication.";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama3-8b-8192',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            if ($response->failed()) {
                return back()->with('error', 'Erreur lors de l\'appel à l\'API Groq. Veuillez réessayer.');
            }

            $body = $response->json();

            if (!isset($body['choices'][0]['message']['content'])) {
                return back()->with('error', 'Réponse inattendue de l\'API. Veuillez réessayer.');
            }

            $content = $body['choices'][0]['message']['content'];
            $parsed = json_decode($content, true);

            if (!is_array($parsed) || count($parsed) !== 5) {
                return back()->with('error', 'Format de réponse invalide. Veuillez réessayer.');
            }

            $concept->generatedQuestions()->create([
                'questions' => $parsed,
            ]);

            return redirect()->route('domains.concepts.show', [$concept->domain, $concept])
                ->with('success', 'Questions générées avec succès.');

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur de connexion à l\'API Groq. Veuillez réessayer.');
        }
    }

    public function destroy(GeneratedQuestion $generatedQuestion): RedirectResponse
    {
        $concept = $generatedQuestion->concept;

        abort_if($concept->domain->user_id !== auth()->id(), 403);

        $generatedQuestion->delete();

        return redirect()->route('domains.concepts.show', [$concept->domain, $concept])
            ->with('success', 'Génération supprimée.');
    }
}
