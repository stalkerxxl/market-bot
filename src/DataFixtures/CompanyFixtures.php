<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Industry;
use App\Entity\Sector;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class CompanyFixtures extends Fixture
{
    private PropertyAccessorInterface $propertyAccessor;

    public function __construct()
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
            ->disableExceptionOnInvalidPropertyPath()
            ->disableExceptionOnInvalidIndex()
            ->getPropertyAccessor();
    }

    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $data = self::getData()['valid'][0];

        $sector = new Sector();
        $sector->setName($data['sector']);
        $manager->persist($sector);

        $industry = new Industry();
        $industry->setName($data['industry']);
        $industry->setSector($sector);
        $manager->persist($industry);

        $company = new Company();
        $company->setName($data['companyName']);
        $company->setIpoDate(new \DateTimeImmutable($data['ipoDate']));
        $company->setImageUrl($data['image']);
        $company->setSector($sector)->setIndustry($industry);

        unset($data['sector'], $data['industry'], $data['ipoDate'], $data['image']);
        foreach ($data as $property => $value) {
            $this->propertyAccessor->setValue($company, $property, $value);
        }

        $manager->persist($company);
        $manager->flush();
    }

    #[ArrayShape(['valid' => "array[]", 'invalid' => "array[]", 'empty' => "array"])]
    public static function getData(): array
    {
        return [
            'valid' => [[
                "symbol" => "AAPL",
                "price" => 137.87,
                "beta" => 1.27241,
                "volAvg" => 81738286,
                "mktCap" => 2183336820736,
                "lastDiv" => 0.91,
                "range" => "124.17-179.61",
                "changes" => 2.5999908,
                "companyName" => "Apple Inc.",
                "currency" => "USD",
                "cik" => "0000320193",
                "isin" => "US0378331005",
                "cusip" => "037833100",
                "exchange" => "NASDAQ Global Select",
                "exchangeShortName" => "NASDAQ",
                "industry" => "Consumer Electronics",
                "website" => "https://www.apple.com",
                "description" => "Apple Inc. designs, manufactures, and markets smartphones, personal computers, tablets, wearables, and accessories worldwide. It also sells various related services. In addition, the company offers iPhone, a line of smartphones; Mac, a line of personal computers; iPad, a line of multi-purpose tablets; and wearables, home, and accessories comprising AirPods, Apple TV, Apple Watch, Beats products, and HomePod. Further, it provides AppleCare support and cloud services store services; and operates various platforms, including the App Store that allow customers to discover and download applications and digital content, such as books, music, video, games, and podcasts. Additionally, the company offers various services, such as Apple Arcade, a game subscription service; Apple Fitness+, a personalized fitness service; Apple Music, which offers users a curated listening experience with on-demand radio stations; Apple News+, a subscription news and magazine service; Apple TV+, which offers exclusive original content; Apple Card, a co-branded credit card; and Apple Pay, a cashless payment service, as well as licenses its intellectual property. The company serves consumers, and small and mid-sized businesses; and the education, enterprise, and government markets. It distributes third-party applications for its products through the App Store. The company also sells its products through its retail and online stores, and direct sales force; and third-party cellular network carriers, wholesalers, retailers, and resellers. Apple Inc. was incorporated in 1977 and is headquartered in Cupertino, California.",
                "ceo" => "Mr. Timothy Cook",
                "sector" => "Technology",
                "country" => "US",
                "fullTimeEmployees" => "164000",
                "phone" => "14089961010",
                "address" => "1 Apple Park Way",
                "city" => "Cupertino",
                "state" => "CALIFORNIA",
                "zip" => "95014",
                "dcfDiff" => 12.2118,
                "dcf" => 150.082,
                "image" => "https://financialmodelingprep.com/image-stock/AAPL.png",
                "ipoDate" => "1980-12-12",
                "defaultImage" => false,
                "isEtf" => false,
                "isActivelyTrading" => true,
                "isAdr" => false,
                "isFund" => false
            ]],
            'invalid' => [[
                "symbol" => "AAPL",
                "price" => null,
                "beta" => null,
            ]],
            'empty' => []
        ];
    }
}
