<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Gets the current logged user in the system.
     *
     * @return Authenticatable|null
     */
    public function getLoggedUser()
    {
        return auth()->user();
    }

    /**
     * Chooses the correct view for the logged user,
     * this is based on the user flag is_admin
     *
     * @return Application|Factory|View
     */
    public function show()
    {
        // Get the store procedure that carries the user data
        $userData = (new User)->getUserInfo($this->getLoggedUser()->id)[0];

        // Get via Eloquent the users and userRoles
        $systemUsers = User::with(['enabledUserRoles.role'])
            ->where('is_admin', false)
            ->get();

        if ($userData->is_admin) {
            return view('adminHome')
                ->with('systemUsers', $systemUsers)
                ->with('userData', $userData);
        } else {
            return view('home')->with('userData', $userData);
        }
    }

    /**
     * Collects the data for the edit view
     *
     * @return Application|Factory|View
     */
    public function edit()
    {
        // Get the store procedure that carries the user data
        $userData = (new User)->getUserInfo($this->getLoggedUser()->id);

        return view('editProfile')->with('userData', $userData[0]);
    }

    /**
     * Validates the data sent in the request
     *
     * @param array $data
     * @param array $request
     * @return bool|JsonResponse
     */
    protected function validateRequest(array $data, array $request)
    {
        $validator = Validator::make($request, $data);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'data'   => $validator->getMessageBag()->getMessages()
            ]);
        }
        return true;
    }

    /**
     * Updates the current logged user
     *
     * @param Request $request
     * @return bool|JsonResponse
     */
    public function update(Request $request)
    {
        $payload = $request->all();
        $validator = $this->validateRequest($request->all(),[
            'name'      => ['required', 'string'],
            'gender'    => ['string'],
            'address'   => ['string'],
            'postcode'  => ['string'],
            'county'    => ['string'],
            'phone'     => ['string'],
            'about_me'  => ['string', 'max:255']
        ]);

        if ($validator !== true){
            return $validator;
        }

        unset($payload['_token']);

        try {
            DB::beginTransaction();

            User::where('id', $this->getLoggedUser()->id)
                ->update($payload);

            DB::commit();
        } catch( \Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'There was an error saving your data, please try again later.'
            ]);
        }

        return response()->json([
            'status'    => 'success',
            'data'      => 'home'
        ]);
    }

    /**
     * Gets the data to show in the edit page for
     * user role.
     *
     * @param string $userId
     * @return Application|Factory|View
     */
    public function editUserRole(string $userId)
    {
        $user = (new User)->getUserInfo($userId)[0];
        $availableRoles = Roles::where('id', '!=', Roles::ADMIN)
            ->pluck('name', 'id')
            ->toArray();

        $userRoles = UserRoles::where('user_id', $userId)
            ->where('enabled', true)
            ->pluck('role_id')
            ->toArray();

        return view('roles.editRoles')
            ->with('user', $user)
            ->with('userRoles', $userRoles)
            ->with('roles', $availableRoles);
    }

    /**
     * Makes the update of the roles for the
     * edited user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateUserRole(Request $request)
    {
        $payload = $request->all();
        $validator = $this->validateRequest($request->all(),[
            'roles' => ['required', 'array']
        ]);

        if ($validator !== true){
            return $validator;
        }

        unset($payload['_token']);

        try {
            DB::beginTransaction();

            UserRoles::addChanges($payload);

            DB::commit();
        } catch( \Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'There was an error saving your data, please try again later.'
            ]);
        }

        return response()->json([
            'status'    => 'success',
            'data'      => 'home'
        ]);
    }
}
