<?php

declare(strict_types=1);

/*
 * This file has been auto generated by Jane,
 *
 * Do no edit it directly.
 */

namespace Docker\API\Normalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class TaskSpecContainerSpecPrivilegesNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;

    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === 'Docker\\API\\Model\\TaskSpecContainerSpecPrivileges';
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof \Docker\API\Model\TaskSpecContainerSpecPrivileges;
    }

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if (!is_object($data)) {
            return null;
        }
        $object = new \Docker\API\Model\TaskSpecContainerSpecPrivileges();
        if (property_exists($data, 'CredentialSpec') && $data->{'CredentialSpec'} !== null) {
            $object->setCredentialSpec($this->denormalizer->denormalize($data->{'CredentialSpec'}, 'Docker\\API\\Model\\TaskSpecContainerSpecPrivilegesCredentialSpec', 'json', $context));
        }
        if (property_exists($data, 'SELinuxContext') && $data->{'SELinuxContext'} !== null) {
            $object->setSELinuxContext($this->denormalizer->denormalize($data->{'SELinuxContext'}, 'Docker\\API\\Model\\TaskSpecContainerSpecPrivilegesSELinuxContext', 'json', $context));
        }

        return $object;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $data = new \stdClass();
        if (null !== $object->getCredentialSpec()) {
            $data->{'CredentialSpec'} = $this->normalizer->normalize($object->getCredentialSpec(), 'json', $context);
        }
        if (null !== $object->getSELinuxContext()) {
            $data->{'SELinuxContext'} = $this->normalizer->normalize($object->getSELinuxContext(), 'json', $context);
        }

        return $data;
    }
}
