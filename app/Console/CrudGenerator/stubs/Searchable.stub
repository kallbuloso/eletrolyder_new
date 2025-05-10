<?php

namespace App\Traits;

trait SearchableTrait {

  /**
   * Scope a query to search a model.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param string $search
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeSearch($query, $search)
  {
    if (empty($search)) {
      return $query;
    }

    $searchable = $this->getSearchable();

    $query->where(function ($query) use ($searchable, $search) {
      foreach ($searchable as $field) {
        $query->orWhere($field, 'LIKE', "%{$search}%");
      }
    });

    return $query;
  }

  /**
   * Get the searchable fields for the model.
   *
   * @return array
   */
  public function getSearchable()
  {
    return $this->searchable ?? [];
  }
}
