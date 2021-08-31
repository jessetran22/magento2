<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @group Rss
 * @Title("MC-36686: RSS Feed")
 * @Description("View selected RSS feed by link.<h3>Test files</h3>app/code/Magento/Rss/Test/Mftf/Test/RssListTest.xml<br>")
 * @TestCaseId("MC-36686")
 */
class RssListTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createProduct", "hook", "SimpleProductWithNewFromDate", [], []); // stepKey: createProduct
		$enableRss = $I->magentoCLI("config:set rss/config/active 1", 60); // stepKey: enableRss
		$I->comment($enableRss);
		$enableRssForCatalogNewProducts = $I->magentoCLI("config:set rss/catalog/new 1", 60); // stepKey: enableRssForCatalogNewProducts
		$I->comment($enableRssForCatalogNewProducts);
		$cleanCache = $I->magentoCLI("cache:clean", 60); // stepKey: cleanCache
		$I->comment($cleanCache);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$disableRss = $I->magentoCLI("config:set rss/config/active 0", 60); // stepKey: disableRss
		$I->comment($disableRss);
		$disableRssForCatalogNewProducts = $I->magentoCLI("config:set rss/catalog/new 0", 60); // stepKey: disableRssForCatalogNewProducts
		$I->comment($disableRssForCatalogNewProducts);
		$cleanCache = $I->magentoCLI("cache:clean", 60); // stepKey: cleanCache
		$I->comment($cleanCache);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Stories({"RSS Feed available to view"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Features({"Rss"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function RssListTest(AcceptanceTester $I)
	{
		$I->amOnPage("/rss/"); // stepKey: goToRssPage
		$I->seeElement("table.rss"); // stepKey: seeRssList
		$I->click("table.rss tr:nth-of-type(2) > td.action a"); // stepKey: clickRssLink
		$I->seeInCurrentUrl("rss/feed/index/type/new_products/"); // stepKey: seeInUrl
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->see("New Products from Main Website Store"); // stepKey: seeText
	}
}
