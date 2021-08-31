<?php
namespace Magento\AcceptanceTest\_SearchEngineElasticsearchSuite\Backend;

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
 * @Title("MC-28917: Product quick search doesn't throw exception after ES is chosen as search engine with different amount per page")
 * @Description("Verify no elastic search exception is thrown when searching for products, when displayed products per page are greater or equal the size of available products.<h3>Test files</h3>app/code/Magento/Elasticsearch6/Test/Mftf/Test/StorefrontProductQuickSearchUsingElasticSearchTest.xml<br>")
 * @TestCaseId("MC-28917")
 * @group catalog
 * @group elasticsearch
 * @group SearchEngineElasticsearch
 * @group catalog_search
 */
class StorefrontProductQuickSearchUsingElasticSearchTestCest
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
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$createFirstProductFields['name'] = "AAA Product Simple AAA";
		$I->createEntity("createFirstProduct", "hook", "SimpleProduct2", [], $createFirstProductFields); // stepKey: createFirstProduct
		$createSecondProductFields['name'] = "Product Simple AAA";
		$I->createEntity("createSecondProduct", "hook", "SimpleProduct2", [], $createSecondProductFields); // stepKey: createSecondProduct
		$setCustomGridPerPageValues = $I->magentoCLI("config:set catalog/frontend/grid_per_page_values 1,2", 60); // stepKey: setCustomGridPerPageValues
		$I->comment($setCustomGridPerPageValues);
		$setCustomGridPerPageDefaults = $I->magentoCLI("config:set catalog/frontend/grid_per_page 1", 60); // stepKey: setCustomGridPerPageDefaults
		$I->comment($setCustomGridPerPageDefaults);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createFirstProduct", "hook"); // stepKey: deleteFirstProduct
		$I->deleteEntity("createSecondProduct", "hook"); // stepKey: deleteSecondProduct
		$setDefaultGridPerPageValues = $I->magentoCLI("config:set catalog/frontend/grid_per_page_values 12,24,36", 60); // stepKey: setDefaultGridPerPageValues
		$I->comment($setDefaultGridPerPageValues);
		$setDefaultGridPerPageDefaults = $I->magentoCLI("config:set catalog/frontend/grid_per_page 12", 60); // stepKey: setDefaultGridPerPageDefaults
		$I->comment($setDefaultGridPerPageDefaults);
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
	 * @Features({"Elasticsearch6"})
	 * @Stories({"Storefront Search"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontProductQuickSearchUsingElasticSearchTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openStorefrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageOpenStorefrontHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenStorefrontHomePage
		$I->comment("Exiting Action Group [openStorefrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [quickSearchSimpleProduct] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "AAA"); // stepKey: fillInputQuickSearchSimpleProduct
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchSimpleProduct
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchSimpleProduct
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchSimpleProduct
		$I->seeInTitle("Search results for: 'AAA'"); // stepKey: assertQuickSearchTitleQuickSearchSimpleProduct
		$I->see("Search results for: 'AAA'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchSimpleProduct
		$I->comment("Exiting Action Group [quickSearchSimpleProduct] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [assertFirstProductOnCatalogSearchPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createFirstProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertFirstProductOnCatalogSearchPage
		$I->comment("Exiting Action Group [assertFirstProductOnCatalogSearchPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertSecondProductIsMissingOnCatalogSearchPage] StorefrontCheckProductIsMissingInCategoryProductsPageActionGroup");
		$I->dontSee("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSecondProduct', 'name', 'test') . "')]"); // stepKey: dontSeeCorrectProductsOnStorefrontAssertSecondProductIsMissingOnCatalogSearchPage
		$I->comment("Exiting Action Group [assertSecondProductIsMissingOnCatalogSearchPage] StorefrontCheckProductIsMissingInCategoryProductsPageActionGroup");
		$I->click(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'next')]"); // stepKey: clickNextPageCatalogSearchPager
		$I->waitForPageLoad(30); // stepKey: clickNextPageCatalogSearchPagerWaitForPageLoad
		$I->comment("Entering Action Group [assertSecondProductOnCatalogSearchPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSecondProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertSecondProductOnCatalogSearchPage
		$I->comment("Exiting Action Group [assertSecondProductOnCatalogSearchPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertFirstProductIsMissingOnCatalogSearchPage] StorefrontCheckProductIsMissingInCategoryProductsPageActionGroup");
		$I->dontSee("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createFirstProduct', 'name', 'test') . "')]"); // stepKey: dontSeeCorrectProductsOnStorefrontAssertFirstProductIsMissingOnCatalogSearchPage
		$I->comment("Exiting Action Group [assertFirstProductIsMissingOnCatalogSearchPage] StorefrontCheckProductIsMissingInCategoryProductsPageActionGroup");
		$I->selectOption("//*[@class='toolbar toolbar-products'][2]//select[@id='limiter']", "2"); // stepKey: selectDisplayedProductInGridPerPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->dontSeeInCurrentUrl("?p=2"); // stepKey: assertRedirectedToFirstPage
		$I->comment("Entering Action Group [assertFirstProductDisplayedOnCatalogSearchPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createFirstProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertFirstProductDisplayedOnCatalogSearchPage
		$I->comment("Exiting Action Group [assertFirstProductDisplayedOnCatalogSearchPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertSecondProductDisplayedOnCatalogSearchPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSecondProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertSecondProductDisplayedOnCatalogSearchPage
		$I->comment("Exiting Action Group [assertSecondProductDisplayedOnCatalogSearchPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
	}
}
