<?php


namespace App\Http\Services;

use Illuminate\Support\Str;
use App\Models\Game;

class HeadService
{
  private $nameWeb = 'ApkgosuGame';
  private $description = 'Play free online games at ApkGosuGame — new high-quality games daily';
  private $url = 'https://www.apkgosu.fun/';
  private $image = 'https://img.apkgosu.fun/images/apkgosu/share.png?metadata=none&amp;width=1200&amp;height=630&amp;fit=crop'; // fallback image

  public function getHead_game($game)
  {
    if (!$game)
      return '';
    // ✅ Clean & shorten description 
    $descRaw = str_replace('"', "'", $game->description ?: $this->description);
    $descText = strip_tags($descRaw);
    $descText = html_entity_decode($descText, ENT_QUOTES, 'UTF-8');
    $descText = str_replace(
      ['"', '“', '”', '‟', '„', '❝', '❞', '&quot;'],
      "'",
      $descText
    );

    // 4️⃣ Xoá emoji, ký tự đặc biệt không in được (Unicode > BMP)
    $descText = preg_replace('/[\x{1F600}-\x{1F64F}]/u', '', $descText); // Emoticons
    $descText = preg_replace('/[\x{1F300}-\x{1F5FF}]/u', '', $descText); // Symbols & pictographs
    $descText = preg_replace('/[\x{1F680}-\x{1F6FF}]/u', '', $descText); // Transport & map
    $descText = preg_replace('/[\x{2600}-\x{26FF}]/u', '', $descText);   // Misc symbols
    $descText = preg_replace('/[\x{2700}-\x{27BF}]/u', '', $descText);   // Dingbats
    $descText = preg_replace('/\s+/', ' ', trim($descText));

    $descShort = Str::words($descText, 18, '...');
    if (!Str::contains(Str::lower($descShort), 'apkgosu')) {
      $descShort .= ' Play free on Apkgosu!';
    }

    $desc = e($descShort);
    $title = e($game->name . ' - Play Free Online on ' . $this->nameWeb);
    $image = '';
    $width = '';
    $height = '';
    if ($game->imgseo) {
      $image = $game->imgseo;
      $width = 1200;
      $height = 600;
    } else {
      $image = $game->linkImgGame() ?? $this->image;
      $width = $game->wImgGame();
      $height = $game->hImgGame();
    }


    $video = '';
    if ($game->video_y_id) {
      $video = '<script type="application/ld+json">'
        . '{'
        . '"@context": "https://schema.org",'
        . '"@type": "VideoObject",'
        . '"name": "' . $game->name . ' Gameplay",'
        . '"description": "' . $game->name . ' Gameplay",'
        . '"thumbnailUrl": "https://i.ytimg.com/vi/' . $game->video_y_id . 'default.jpg",'
        . '"uploadDate": "' . \Carbon\Carbon::parse($game->updated_at)->toIso8601String() . '",';
      if ($game->duration) {
        $video = $video . '"duration": "' . $game->duration . '",';
      }
      $video = $video
        . '"embedUrl": "https://www.youtube.com/embed/' . $game->video_y_id . '"'
        . '}'
        . '</script>'
      ;
    }
        $videosss= '';
        
        if (!empty($game->video_short)) {
            if (str_contains($game->video_short, 'https://')) {
    $videosss= 
    '<meta data-react-helmet="true" property="og:video" content="'. $game->video_short.'">'.
    '<meta data-react-helmet="true" property="og:video:type" content="video/mp4">'.
    '<meta data-react-helmet="true" property="og:video:width" content="314">'.
    '<meta data-react-helmet="true" property="og:video:height" content="314">';
            }
        }
    // ✅ Build final HTML
    return <<<HTML
    <meta name="keywords" content="{$game->tag_arr_string()}">
    <meta name="description" content="{$desc}">
    <meta property="og:url" content="https://www.apkgosu.fun/g/{$game->slug}">
    <meta property="og:url" content="https://www.apkgosu.fun/g/{$game->slug}">
<meta property="og:title" content="{$game->name} 🕹️ Play on AkpgosuGames">
<meta property="og:description" content="{$desc}">
<meta property="og:locale" content="en_US">
  <meta property="og:image" content="{$image}">
  <meta property="og:image:width" content="{$width}">
  <meta property="og:image:height" content="{$height}">
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="https://www.apkgosu.fun/g/{$game->slug}">
<meta property="twitter:title" content="{$game->name} 🕹️ Play on AkpgosuGames">
<meta property="twitter:description" content="{$desc}">
  <meta property="twitter:image" content="{$image}">
  {$videosss}
  {$video}
HTML;
  } 
  
  public function get_schema_game($game)
  {
    if (!$game)
      return '';

    // ✅ Clean & shorten description 
    $number_play = random_int(50, 200);

    $descRaw = str_replace('"', "'", $game->description ?: $this->description);
    $descText = strip_tags($descRaw);
    $descText = html_entity_decode($descText, ENT_QUOTES, 'UTF-8');
    $descText = str_replace(
      ['"', '“', '”', '‟', '„', '❝', '❞', '&quot;'],
      "'",
      $descText
    );

    // 4️⃣ Xoá emoji, ký tự đặc biệt không in được (Unicode > BMP)
    $descText = preg_replace('/[\x{1F600}-\x{1F64F}]/u', '', $descText); // Emoticons
    $descText = preg_replace('/[\x{1F300}-\x{1F5FF}]/u', '', $descText); // Symbols & pictographs
    $descText = preg_replace('/[\x{1F680}-\x{1F6FF}]/u', '', $descText); // Transport & map
    $descText = preg_replace('/[\x{2600}-\x{26FF}]/u', '', $descText);   // Misc symbols
    $descText = preg_replace('/[\x{2700}-\x{27BF}]/u', '', $descText);   // Dingbats
    $descText = preg_replace('/\s+/', ' ', trim($descText));

    $descShort = Str::words($descText, 18, '...');
    if (!Str::contains(Str::lower($descShort), 'apkgosu')) {
      $descShort .= ' Play free on Apkgosu!';
    }

    $image_url = '';
    $width = 0;
    $height = 0;
    if ($game->imgseo) {
      $image_url = $game->imgseo;
      $width = 1200;
      $height = 630;
    } else {
      $image_url = $game->linkImgGame() ?? $this->image;
      $width = $game->wImgGame();
      $height = $game->hImgGame();
    }

    $url = 'https://www.apkgosu.fun/g/' . $game->slug;
    // ✅ Build final HTML
    

    $image = [
      [
        "@type" => "ImageObject",
        "url" => "{$image_url}",
        "thumbnailUrl" => "{$image_url}",
        "image" => "{$image_url}",
        "contentUrl" => "{$image_url}",
        "width" =>  $width,
        "height" =>  $height
      ]
    ];

    $breadcrumb = [
      "@type" => "BreadcrumbList",
      "itemListElement" => [
        [
          "@type" => "ListItem",
          "position" => 1,
          "item" => [
            "@type" => "Thing",
            "@id" => "https://www.apkgosu.fun",
            "name" => "Apkgosu_fun"
          ]
        ],
        [
          "@type" => "ListItem",
          "position" => 2,
          "item" => [
            "@type" => "Thing",
            "@id" => "https://www.apkgosu.fun/c/{$game->getTheloai()->slug}",
            "name" => "{$game->getTheloai()->names()}"
          ]
        ],
        [
          "@type" => "ListItem",
          "position" => 3,
          "item" => [
            "@type" => "Thing",
            "@id" => "https://www.apkgosu.fun/g/{$game->slug}",
            "name" => "{$game->name}"
          ]
        ]
      ]
    ];
    $mainEntity =[
      "@type"=> [
          "VideoGame",
          "WebApplication"
        ],
        "name"=>"{$game->name}",
        "description"=> "{$descShort}",
        "url"=> "https://www.apkgosu.fun/g/{$game->slug}",
        "image"=> $image,
        "operatingSystem"=> "Web Browser",
        "gamePlatform"=> "Apkgosu_fun",
        "availableOnDevice"=> [
          "Mobile",
          "Tablet",
          "Desktop"
        ],
        "author"=>  [
          "@type"=>  "Person",
          "name"=>  "Apkgosu Dev"
        ],
        "aggregateRating"=> [
          "@type"=> "AggregateRating",
          "worstRating"=> 1,
          "bestRating"=> 5,
          "ratingValue"=> "4.8",
          "reviewCount"=> "{$number_play}"
        ],
        "offers"=>[
          "@type"=> "Offer",
          "price"=> 0,
          "priceCurrency"=> "EUR",
          "availability"=>"http://schema.org/InStock"
        ],
        "screenshot"=> $image,
        "potentialAction"=> [
          "@type"=>"PlayAction",
          "target"=> "{$url}",
          "name"=> "{$game->name}"
    ]
    ];

    
    $publisher = $this->getPublisherData();
    $hasPart = $this->getHasPartData();

    $isPartOf = [
      "@type" => "WebSite",
      "@id" => "https://www.apkgosu.fun/#website",
      "name" => "Apkgosu.fun",
      "url" => "https://www.apkgosu.fun",
      "description" => "Apkgosu.fun is the top platform for free online games on mobile, tablet, and desktop. No installation, no sign-in needed. Start playing instantly!",
      "inLanguage" => "en",
      "publisher" => $publisher,
      "hasPart" => $hasPart,
    ];
    $schema = [
      "@context" => "http://schema.org",
      "@graph" => [
        [
          "@type" => "ItemPage",
          "@id" => "{$url}/#ItemPage",
          "url" => "{$url}",
          "name" => "{$game->name}",
          "description" => "{$descShort}",
          "inLanguage" => "en",
          "breadcrumb" => $breadcrumb,
          "primaryImageOfPage" => $image,
          "image" => $image,
          "mainEntity" => $mainEntity,
          "isPartOf" => $isPartOf,
        ]
      ]
    ];

    return $this->renderSchema($schema);
  }
  public function get_schema_category($category)
  {
    if (!$category)
      return '';

    $url = $this->url . 'c/' . $category->slug;

    $image = [
      [
        "@type" => "ImageObject",
        "url" => "{$category->imgCategorySeo()}",
        "thumbnailUrl" => "{$category->imgCategorySeo()}",
        "image" => "{$category->imgCategorySeo()}",
        "contentUrl" => "{$category->imgCategorySeo()}",
        "width" => 1200,
        "height" => 630
      ]
    ];

    $breadcrumb = [
      "@type" => "BreadcrumbList",
      "itemListElement" => [
        [
          "@type" => "ListItem",
          "position" => 1,
          "item" => [
            "@type" => "Thing",
            "@id" => "https://www.apkgosu.fun",
            "name" => "Apkgosu_fun"
          ]
        ],
        [
          "@type" => "ListItem",
          "position" => 2,
          "item" => [
            "@type" => "Thing",
            "@id" => "https://www.apkgosu.fun/c/{$category->slug}",
            "name" => "{$category->name}"
          ]
        ]
      ]
    ];
    $mainEntity = $this->getMainEntityData($category->id);

    
    $publisher = $this->getPublisherData();
    $hasPart = $this->getHasPartData();

    $isPartOf = [
      "@type" => "WebSite",
      "@id" => "https://www.apkgosu.fun/#website",
      "name" => "Apkgosu.fun",
      "url" => "https://www.apkgosu.fun",
      "description" => "Apkgosu.fun is the top platform for free online games on mobile, tablet, and desktop. No installation, no sign-in needed. Start playing instantly!",
      "inLanguage" => "en",
      "publisher" => $publisher,
      "hasPart" => $hasPart,
    ];
    $schema = [
      "@context" => "http://schema.org",
      "@graph" => [
        [
          "@type" => "CollectionPage",
          "@id" => "{$url}/#CollectionPage",
          "url" => "{$url}",
          "name" => "{$category->name}",
          "description" => "{$category->mo_ta_ngan}",
          "inLanguage" => "en",
          "image" => $image,
          "primaryImageOfPage" => $image,
          "thumbnail" => $image,
          "thumbnailUrl" => "{$category->imgCategorySeo()}",
          "breadcrumb" => $breadcrumb,
          "mainEntity" => $mainEntity,
          "isPartOf" => $isPartOf,
        ]
      ]
    ];

    return $this->renderSchema($schema);
  }

  public function get_20_top_home($id_c = null)
  {
    $itemListElement = [];
    $games = [];
    if ($id_c) {
      $games = Game::where('category_id', $id_c)
        ->orderBy('vote_like', 'DESC')
        ->limit(value: 20)
        ->get();
    } else {

      $games = Game::orderBy('vote_like', 'DESC')
        ->limit(value: 20)
        ->get();
    }

    foreach ($games as $i => $game) {
      $itemListElement[] = [
        "@type" => "ListItem",
        "position" => ($i + 1),
        "name" => "{$game->name}",
        "url" => "{$game->copylink()}"
      ];
    }
    return $itemListElement;
  }
  public function get_schema_home()
  {
    $publisher = $this->getPublisherData();
    $hasPart = $this->getHasPartData();
    $mainEntity = $this->getMainEntityData();
    $image = [
      [
        "@type" => "ImageObject",
        "url" => "https://img.apkgosu.fun/images/apkgosu/share.png",
        "width" => 1200,
        "height" => 630
      ]
    ];

    $isPartOf = [
      "@type" => "WebSite",
      "@id" => "https://www.apkgosu.fun/#website",
      "name" => "Apkgosu.fun",
      "url" => "https://www.apkgosu.fun",
      "description" => "Apkgosu.fun is the top platform for free online games on mobile, tablet, and desktop. No installation, no sign-in needed. Start playing instantly!",
      "inLanguage" => "en",
      "publisher" => $publisher,
      "hasPart" => $hasPart,
    ];

    $schema = [
      "@context" => "http://schema.org",
      "@graph" => [
        [
          "@type" => "WebPage",
          "@id" => "https://www.apkgosu.fun/#WebPage",
          "url" => "https://www.apkgosu.fun/",
          "name" => "Online Games at Apkgosu.fun",
          "description" => $isPartOf['description'],
          "inLanguage" => "en",
          "image" => $image,
          "mainEntity" => $mainEntity,
          "isPartOf" => $isPartOf,
        ]
      ]
    ];

    return $this->renderSchema($schema);
  }

  private function renderSchema(array $schema): string
  {
    $json = json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    return <<<HTML
<script type="application/ld+json">{$json}</script>
HTML;
  }

  private function getPublisherData(): array
  {
    return [
      "@type" => "Organization",
      "@id" => "https://www.apkgosu.fun/#organization",
      "url" => "https://www.apkgosu.fun",
      "name" => "Apkgosu.fun",
      "legalName" => "Apkgosu Games",
      "telephone" => "+84563084069",
      "description" => "Apkgosu.fun is a free online games platform that offers more than 1500 games from a global community of creators to over 100 million monthly playing users.",
      "logo" => "https://img.apkgosu.fun/images/favicons/favicon-180x180.png",
      "brand" => [
        "@type" => "Brand",
        "@id" => "https://www.apkgosu.fun/#brand",
        "name" => "Apkgosu.fun",
        "slogan" => "Let the world play"
      ],
      "email" => "game@apkgosu.fun",
      "sameAs" => $this->getsameAsData(),
    ];
  }

  private function getHasPartData(): array
  {
    return [
      [
        "@type" => "SoftwareApplication",
        "@id" => "https://chromewebstore.google.com/detail/apk-gosu-%E2%80%93-game-hub/bmpkbjadbncjifjnnebfhmeohffillla#extension",
        "name" => "APK Gosu – Game Hub",
        "applicationCategory" => "BrowserExtension",
        "operatingSystem" => "Google Chrome",
        "downloadUrl" => "https://chromewebstore.google.com/detail/apk-gosu-%E2%80%93-game-hub/bmpkbjadbncjifjnnebfhmeohffillla?hl=vi",
        "softwareVersion" => "1.0.2",
        "offers" => [
          "@type" => "Offer",
          "price" => 0,
          "priceCurrency" => "USD",
          "availability" => "https://schema.org/InStock"
        ],
        "publisher" => [
          "@type" => "Organization",
          "@id" => "https://www.apkgosu.fun/#organization",
          "name" => "Apkgosu"
        ],
        "aggregateRating" => [
          "@type" => "AggregateRating",
          "bestRating" => 5,
          "worstRating" => 1,
          "ratingValue" => 4.6,
          "ratingCount" => 124,
          "reviewCount" => 32
        ]
      ]
    ];
  }

  private function getsameAsData()
  {
    return
      [
        "https://www.tiktok.com/@apkgosu_fun",
        "https://www.facebook.com/Apkgosu.fun",
        "https://www.instagram.com/apkgosu_game",
        "https://www.youtube.com/@Apkgosu_games",
        "https://x.com/Apkgosu_fun",
        "https://www.pinterest.com/apkgosu_games/",
        "https://www.threads.com/@apkgosu_game",
        "https://medium.com/@apkgosu_fun"
      ];
  }
  private function getMainEntityData($id_c = null): array
  {
    return [
      "@type" => "ItemList",
      "name" => "Games",
      "itemListOrder" => "http://schema.org/ItemListOrderAscending",
      "numberOfItems" => 20,
      "itemListElement" => $this->get_20_top_home($id_c)
    ];
  }
}
