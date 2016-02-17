<?php

abstract class Sample
{
    public function options()
    {
        # create client configuration class
        $options = new \Iyzipay\Options();
        $options->setApiKey("api key");
        $options->setSecretKey("secret key");
        $options->setBaseUrl("https://stg.iyzipay.com");
        return $options;
    }
}
