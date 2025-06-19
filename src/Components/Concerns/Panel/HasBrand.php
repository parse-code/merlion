<?php

namespace Merlion\Components\Concerns\Panel;

trait HasBrand
{
    protected mixed $brandName = 'App';
    protected mixed $brandLogo = null;
    protected mixed $brandSmallLogo = null;
    protected mixed $brandLogoDark = null;
    protected mixed $brandSmallLogoDark = null;

    public function brandName($brandName): static
    {
        $this->brandName = $brandName;
        return $this;
    }

    public function getBrandName()
    {
        return $this->evaluate($this->brandName);
    }

    public function brandLogo($brandLogo): static
    {
        $this->brandLogo = $brandLogo;
        return $this;
    }

    public function getBrandLogo()
    {
        return $this->evaluate($this->brandLogo) ?? $this->asset('images/logo-light.png');
    }

    public function brandSmallLogo($brandSmallLogo): static
    {
        $this->brandSmallLogo = $brandSmallLogo;
        return $this;
    }

    public function getBrandSmallLogo(): string
    {
        return $this->evaluate($this->brandSmallLogo) ?? $this->asset('images/logo-sm-light.png');
    }

    public function brandLogoDark($brandLogoDark): static
    {
        $this->brandLogoDark = $brandLogoDark;
        return $this;
    }

    public function getBrandLogoDark(): string
    {
        return $this->evaluate($this->brandLogoDark)  ?? $this->asset('images/logo-dark.png');
    }

    public function brandSmallLogoDark($brandSmallLogoDark): static
    {
        $this->brandSmallLogoDark = $brandSmallLogoDark;
        return $this;
    }

    public function getBrandSmallLogoDark(): string
    {
        return $this->evaluate($this->brandSmallLogoDark)  ?? $this->asset('images/logo-sm-dark.png');
    }

}
