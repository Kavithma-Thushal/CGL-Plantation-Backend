<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageTimelineResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'user_package_id' => $this->user_package_id,
      'name' => str_replace('_', ' ', $this->packageStatus->name),
      'color' => $this->packageStatus->color,
      'status' => $this->status,
      'created_at' => $this->created_at,
      'package_status_id' => $this->package_status_id,
      'created_user_id' => $this->created_user_id,
      'reason'=>$this->reason
    ];
  }
}
