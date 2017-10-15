<?php

namespace Cog\Laravel\Optimus\Traits;

use Cog\Laravel\Optimus\Facades\Optimus;

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
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value)
    {
        $id = $this->getOptimus()->decode($value);

        return $this->where($this->getRouteKeyName(), '=', $id)->first();
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

        return Optimus::connection($connection);
    }
}
