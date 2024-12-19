<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\LoginToken;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index(Request $request){
        $token=LoginToken::where('token', $request->token)->first();
        $data = Board::where('creator_id', $token->id)->get();
        return response()->json([
            'data' => $data
        ]);
    }

    public function show(Request $request, string $id){
        $token=LoginToken::where('token', $request->token)->first();
        $data = Board::where('creator_id', $token->id)->find($id);
        return response()->json([
            'data' => $data
        ]);
    }

    public function create(Request $request)
    {
        $token=LoginToken::where('token', $request->token)->first();
        if($token){
            $request->validate(['name'=>'required']);
            $name=$request->name;
            $board=Board::Create([
                'name'=>$name,
                'creator_id'=>$token->user_id
            ]);
            return response()->json(['message'=>'create board success'],200);
       }
       return response()->json(['message'=>'unauthorized user'],401);
    }

    public function update(Request $request, string $id){
        $token=LoginToken::where('token', $request->token)->first();
        if($token){
            $update=Board::where('creator_id', $token->id)->find($id);
            if($id){
                $update->name=$request->name;
                $update->save();
                return response()->json(['message'=>'update board success'],200);
            }
            return response()->json(['message'=>'invalid field'],422);

        }
        return response()->json(['message'=>'unauthorized user'],401);
    }

    public function destroy(Request $request, string $id) {
        $token = LoginToken::where('token', $request->token)->first();
        if ($token) {
            $board = Board::where('creator_id', $token->user_id)->find($id);
            if ($board) {
                $board->delete();
                return response()->json([
                    'message' => 'Delete board success'
                ], 200);
            }
            return response()->json([
                'message' => 'Invalid field: Board not found'
            ], 422);
        }

        return response()->json([
            'message' => 'Unauthorized user'
        ], 401);
    }

}
