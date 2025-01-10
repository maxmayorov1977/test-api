<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

use Illuminate\Support\Facades\Response;

class OrganizationController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function organizations(): JsonResponse
    {
        $organizations = Organization::query()
            ->with(['building', 'phones', 'activities', 'activities.subActivities'])
            ->simplePaginate();

        return Response::json([
            'organizations' => $organizations,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function organizationById(): JsonResponse
    {
        $id = Request::get('id');

        $organization = Organization::query()
            ->with(['building', 'phones', 'activities', 'activities.subActivities'])
            ->find($id);

        if (is_null($organization)) {
            return Response::json(status: SymfonyResponse::HTTP_NOT_FOUND);
        }

        return Response::json([
            'organizations' => $organization,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function organizationByName(): JsonResponse
    {
        $name = Request::get('name');

        $organization = Organization::query()
            ->with(['building', 'phones', 'activities', 'activities.subActivities'])
            ->where('name', '=', $name)
            ->first();

        if (is_null($organization)) {
            return Response::json(status: SymfonyResponse::HTTP_NOT_FOUND);
        }

        return Response::json([
            'organizations' => $organization,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function organizationsByBuilding(): JsonResponse
    {
        $address = Request::get('address');

        $organizations = Organization::query()
            ->with(['building', 'phones', 'activities', 'activities.subActivities'])
            ->whereHas('building', static function ($query) use ($address) {
                $query->where('address', $address);
            })
            ->simplePaginate();

        if ($organizations->isEmpty()) {
            return Response::json(status: SymfonyResponse::HTTP_NOT_FOUND);
        }

        return Response::json([
            'organizations' => $organizations,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function organizationsByActivity(): JsonResponse
    {
        $activity = Request::get('activity');

        $organizations = Organization::query()
            ->with(['building', 'phones', 'activities', 'activities.subActivities'])
            ->whereHas('activities', static function ($query) use ($activity) {
                $query->where('name', $activity);
            })
            ->simplePaginate();

        if ($organizations->isEmpty()) {
            return Response::json(status: SymfonyResponse::HTTP_NOT_FOUND);
        }

        return Response::json([
            'organizations' => $organizations,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function organizationsByAllActivities(): JsonResponse
    {
        $activity = Request::get('activity');

        $organizations = Organization::query()
            ->with(['building', 'phones', 'activities', 'activities.subActivities'])
            ->whereHas('activities', static function ($query) use ($activity) {
                $query->where('name', $activity);
            })
            ->orWhereHas('activities.subActivities', static function ($query) use ($activity) {
                $query->where('name', $activity);
            })
            ->simplePaginate();

        if ($organizations->isEmpty()) {
            return Response::json(status: SymfonyResponse::HTTP_NOT_FOUND);
        }

        return Response::json([
            'organizations' => $organizations,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function organizationsByCoordinates(): JsonResponse
    {
        $latitude = Request::get('latitude');
        $longitude = Request::get('longitude');

        $organizations = Building::query()
            ->with('organizations')
            ->whereHas('organizations')
            ->whereBetween('latitude', [$latitude - 100, $latitude + 100])
            ->whereBetween('longitude', [$longitude - 100, $longitude + 100])
            ->simplePaginate();

        if ($organizations->isEmpty()) {
            return Response::json(status: SymfonyResponse::HTTP_NOT_FOUND);
        }

        return Response::json([
            'organizations' => $organizations,
        ]);
    }
}
