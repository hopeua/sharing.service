<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use AppBundle\Media\Media;
use AppBundle\Media\Image;
use AppBundle\Media\Video;
use AppBundle\Media\Source;
/**
 * EpisodeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EpisodeRepository extends EntityRepository
{
    /**
     * @return Episode[]
     */
    public function getAll()
    {
        /**
         * @var \AppBundle\Entity\Episode[] $episodes
         */
        $episodes = $this->findBy([], null, 10);
        foreach ($episodes as $episode)
        {
            $this->injectMedia($episode);
        }

        return $episodes;
    }

    /**
     * @param $code
     *
     * @return Episode
     */
    public function getOne($code)
    {
        /**
         * @var \AppBundle\Entity\Episode $episode
         */
        $episode = $this->findOneBy(['code' => $code]);
        $this->injectMedia($episode);

        return $episode;
    }

    /**
     * @param Episode $episode
     */
    private function injectMedia(Episode $episode)
    {
        $media = new Media();

        $image = new Image();
        $image->setUrl(sprintf('http://share.yourhope.tv/%s.jpg', $episode->getCode()));
        $media->setImage($image);

        $video = new Video();

        $localSource = new Source\Local();
        $localSource->setUrl(sprintf('http://share.yourhope.tv/%s.mov', $episode->getCode()));
        $localSource->setSize(0);

        $video->addSource($localSource);

        if ($episode->getYoutube() !== null) {
            $youtubeSource = new Source\Youtube();
            $youtubeSource->setId($episode->getYoutube()->getLink());

            $video->addSource($youtubeSource);
        }

        $media->setVideo($video);

        $episode->setMedia($media);
    }
}
