<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new AppBundle\AppBundle(),
            new AssociationBundle\AssociationBundle(),
            new MissionBundle\MissionBundle(),
            new DonsBundle\DonsBundle(),
            new CommunicationBundle\CommunicationBundle(),
            new RefugeeBundle\RefugeeBundle(),
            new ReclamationBundle\ReclamationBundle(),
            new BackofficeBundle\BackofficeBundle(),
            // Bundle externe mouhamed
            new SBC\NotificationsBundle\NotificationsBundle(),
            // Bundle externe nasri
            //new JMS\SerializerBundle\JMSSerializerBundle(),
            //new JMS\SerializerBundle\JMSSerializerBundle(),

            //new FOS\RestBundle\FOSRestBundle(),
            // Bundle externe Issam
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new EWZ\Bundle\RecaptchaBundle\EWZRecaptchaBundle(),
<<<<<<< HEAD

            //bundle ramy

=======
      //bundle ramy
            //bundle rami
            new blackknight467\StarRatingBundle\StarRatingBundle(),
>>>>>>> 828daa075d4193b154f76a7094238bc737adb040
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            // Bundle Chihab
            
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();

            if ('dev' === $this->getEnvironment()) {
                $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
                $bundles[] = new Symfony\Bundle\WebServerBundle\WebServerBundle();
            }
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function (ContainerBuilder $container) {
            $container->setParameter('container.autowiring.strict_mode', true);
            $container->setParameter('container.dumper.inline_class_loader', true);

            $container->addObjectResource($this);
        });
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}

