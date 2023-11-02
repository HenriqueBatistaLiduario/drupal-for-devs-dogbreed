<?php

namespace Drupal\dogbreed\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GuzzleHttp\ClientInterface;

/**
 * Provides a 'Dog Breed' block.
 *
 * @Block(
 *   id = "dogbreed_block",
 *   admin_label = @Translation("Dog Breed Block"),
 * )
 */
class DogBreedBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected $configFactory;
  protected $httpClient;

  /**
   * Constructs a new DogBreedBlock.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param ConfigFactoryInterface $config_factory
   *   The configuration factory service.
   * @param ClientInterface $http_client
   *   The HTTP client service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory, ClientInterface $http_client) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
    $this->httpClient = $http_client;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('http_client')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->configFactory->get('dogbreed.settings');
    $standardDogBreed = $config->get('standard_dog_breed');

    // Make a request to the dog API.
    $response = $this->httpClient->get("https://dog.ceo/api/breed/$standardDogBreed/images/random");
    $data = json_decode($response->getBody(), TRUE);
    $imageUrl = $data['message'];

    return [
      '#markup' => $this->t('<img src="@url" alt="Random Dog Image">', ['@url' => $imageUrl]),
      '#cache' => ['max-age' => 0], //Desabilitando o cache desse bloco, uma vez que as imagens são randômicas
    ];
  }
}
