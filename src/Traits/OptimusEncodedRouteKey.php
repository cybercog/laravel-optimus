<?php

namespace Cog\Laravel\Optimus\Traits;

trait OptimusEncodedRouteKey
{
    /**
     * Get the value of the model's route key.
     *
     * @return mixed
     */
    public function getRouteKey()
    {
        $id = parent::getRouteKey();

        return $this->getOptimus()->encode($id);
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param mixed $value
     * @param string|null $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if ($field === null) {
            $field = $this->getRouteKeyName();
        }

        if (is_string($value) && ctype_digit($value)) {
            $value = (int) $value;
        }

        if (is_int($value) && $field === $this->getRouteKeyName()) {
            $value = $this->getOptimus()->decode($value);
        }

        return $this->where($field, $value)->first();
    }

    /**
     * Get the Optimus instance.
     *
     * @return \Cog\Laravel\Optimus\OptimusManager
     */
    protected function getOptimus()
    {
        $connection = null;

        if (property_exists($this, 'optimusConnection')) {
            $connection = $this->optimusConnection;
        }

        return app('optimus')->connection($connection);
    }
}
