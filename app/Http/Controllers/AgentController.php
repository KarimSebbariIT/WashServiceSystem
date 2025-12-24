<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    public function index()
    {
        return response()->json(Agent::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|string|email|unique:agents,email|unique:user_accounts,email',
        ]);

        // Create agent profile
        $agent = Agent::create($validated);

        // Create user account for agent
        UserAccount::create([
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone_number'],
            'password' => Hash::make('DefaultPassword123!'), // default password
            'role' => 'agent',
        ]);

        return response()->json($agent, 201);
    }

    public function show($id)
    {
        return response()->json(Agent::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $agent = Agent::findOrFail($id);

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|string|email|unique:agents,email,' . $id . '|unique:user_accounts,email,' . $id,
        ]);

        $agent->update($validated);

        // Update user account too
        $user = UserAccount::where('email', $agent->email)->first();
        if ($user) {
            $user->update([
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone_number'],
            ]);
        }

        return response()->json($agent);
    }

    public function destroy($id)
    {
        $agent = Agent::findOrFail($id);

        // Delete user account linked by email
        $user = UserAccount::where('email', $agent->email)->first();
        if ($user) $user->delete();

        $agent->delete();

        return response()->json(['message' => 'Agent deleted successfully']);
    }
}
