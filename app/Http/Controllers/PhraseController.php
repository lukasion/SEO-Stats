<?php

namespace App\Http\Controllers;

use App\Models\Phrase;
use Illuminate\Http\Request;

class PhraseController extends Controller
{
    /**
     * Deletes a phrase by ID.
     */
    public function phraseDelete(Request $request, int $customerID, int $phraseID)
    {
        return response()->json([
            'result' => Phrase::find($phraseID)->delete()
        ]);
    }

    /**
     * Fetches a phrase details by ID.
     */
    public function detail(Request $request, int $customerID, int $phraseID)
    {
        return response()->json([
            'phrase' => Phrase::find($phraseID)
        ]);
    }

    /**
     * Edits a phrase by ID.
     */
    public function edit(Request $request, int $customerID, int $phraseID)
    {
        $phrase = Phrase::find($phraseID);
        $phrase->name = $request->name;
        $phrase->save();

        return response()->json([
            'phrase' => $phrase
        ]);
    }
}
