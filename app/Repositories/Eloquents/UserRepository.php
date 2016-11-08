<?php

namespace App\Repositories\Eloquents;

use App\Models\User;
use DB;

class UserRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        parent::__construct();
        $this->model = $user;
    }

    public function model()
    {
        return User::class;
    }
    
    public function showAll()
    {
        return $this
            ->select(['id', 'name', 'email'])
            ->withCount(['reviews', 'bookings']);
    }
    
    public function resetPassword($ids)
    {
        try {
            DB::beginTransaction();
            if (!is_array($ids)) {
                $ids = [$ids];
            }

            $users = $this->whereIn('id', $ids)->get()['data'];
            foreach ($users as $user) {
                $user->update(['password' => $user['email']]);
            }

            DB::commit();

            return [
                'status' => true,
                'data' => $users,
            ];
        } catch (Exception $e) {
            DB::rollBack();

            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
