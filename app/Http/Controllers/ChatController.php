<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;
use App\Models\User; //import this

class ChatController extends Controller
{
    public function loadDashboard(){
        // fetch them here except the logged in user as user should not see him or herself in a list
        $all_users = User::where('id','!=',auth()->user()->id)->get();
        return view('dashboard',compact('all_users'));
    }

    public function CheckChannel(Request $request){
            $recipientId = $request->recipientId;
            $loggedInUserId = auth()->user()->id;

            // Check if the channel exists in the database
            $channel = Channel::where(function ($query) use ($recipientId, $loggedInUserId) {
                $query->where('user1_id', $loggedInUserId)
                    ->where('user2_id', $recipientId);
            })->orWhere(function ($query) use ($recipientId, $loggedInUserId) {
                $query->where('user1_id', $recipientId)
                    ->where('user2_id', $loggedInUserId);
            })->first();

            if ($channel) {
                return response()->json([
                    'channelExists' => true,
                    'channelName' => $channel->name,
                ]);
            } else {
                return response()->json([
                    'channelExists' => false,
                ]);
            }
    }

    public function CreateChannel(Request $request){
        $recipientId = $request->recipientId;
        $loggedInUserId = auth()->user()->id;
        try {
            // Generate the channel name
            $channelName = 'chat-' . min($recipientId, $loggedInUserId) . '-' . max($recipientId, $loggedInUserId);
            // this will produce somthing like chat-2-3 as our private channel just for user with the ids used 

            // Create the channel in the database
            $channel = Channel::create([
                'user1_id' => $loggedInUserId,
                'user2_id' => $recipientId,
                'name' => $channelName,
            ]);
            // so let's update the migration file to have the data above

            return response()->json([
                'success' => true,
                'channelName' => $channelName,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
