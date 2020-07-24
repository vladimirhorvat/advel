<?php

namespace Drupal\advel_core\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class TrackingController.
 */
class TrackingController extends ControllerBase
{

  /**
   * Hello.
   *
   * @return string
   *   Return Hello string.
   */
  public function data($param)
  {

    $database = \Drupal::database();
    $query = $database->select('tracking', 't');
    $query->addExpression("DATE_FORMAT(FROM_UNIXTIME(`timestamp`), '%Y-%m-%d %H:%i:%s')");
    $query->orderBy('t.id', 'DESC');
    $query->fields('t', ['lat', 'lon', 'uid']);
    //$sort = $query->extend('Drupal\Core\Database\Query\TableSortExtender')->orderByHeader($header);
    $pager = $query->extend('Drupal\\Core\\Database\\Query\\PagerSelectExtender')->limit(10);
    $res = $pager->execute()->fetchAll(\PDO::FETCH_NUM);

    $table['data'] = array(
      '#type' => 'table',
      '#caption' => $this
        ->t('Sample Table'),
      '#header' => array(
        $this
          ->t('Lat'),
        $this
          ->t('Lon'),
        $this
          ->t('User'),
        $this
          ->t('Time')
      ),
      '#rows' => $res
    );


    $render = [$table];
    $render[] = ['#type' => 'pager'];
    return $render;
  }
}
/* Pager za getQuery i entityQuery se drugacije dodaje:
$header = [
  'id' => [
    'data' => $this->t('ID'),
    'specifier' => 'nid',
  ],
  'title' => [
    'data' => $this->t('Title'),
    'specifier' => 'title',
  ],
  'created' => [
    'data' => $this->t('Created'),
    'specifier' => 'created',
    // Set default sort criteria.
    'sort' => 'desc',
  ],
  'uid' => [
    'data' => $this->t('Author'),
    'specifier' => 'uid',
  ],
];

$storage = \Drupal::entityTypeManager()->getStorage('node');

$query = $storage->getQuery();
$query->condition('status', \Drupal\node\NodeInterface::PUBLISHED);
$query->condition('type', 'article');
$query->tableSort($header);
// Default value is 10.
$query->pager(15);
$nids = $query->execute();

$date_formatter = \Drupal::service('date.formatter');
$rows = [];
foreach ($storage->loadMultiple($nids) as $node) {
  $row = [];
  $row[] = $node->id();
  $row[] = $node->toLink();
  $created = $node->get('created')->value;
  $row[] = [
    'data' => [
      '#theme' => 'time',
      '#text' => $date_formatter->format($created),
      '#attributes' => [
        'datetime' => $date_formatter->format($created, 'custom', \DateTime::RFC3339),
      ],
    ],
  ];
  $row[] = [
    'data' => $node->get('uid')->view(),
  ];
  $rows[] = $row;
}

$build['table'] = [
  '#type' => 'table',
  '#header' => $header,
  '#rows' => $rows,
  '#empty' => $this->t('No content has been found.'),
];

$build['pager'] = [
  '#type' => 'pager',
];
*/
