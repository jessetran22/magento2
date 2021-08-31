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
 * @Title("MC-227: Customer should be able to see search results when searching for bundle products by keyword")
 * @Description("Customer should be able to see search results when searching for bundle products by keyword<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/StorefrontCustomerSearchBundleProductsByKeywordsTest.xml<br>")
 * @TestCaseId("MC-227")
 * @group bundle
 */
class StorefrontCustomerSearchBundleProductsByKeywordsTestCest
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
		$I->createEntity("createSimpleProduct", "hook", "SimpleProductNotVisibleIndividually", [], []); // stepKey: createSimpleProduct
		$I->createEntity("createDynamicBundle", "hook", "DynamicBundleProductCustomDescription", [], []); // stepKey: createDynamicBundle
		$I->createEntity("dynamicBundleOption", "hook", "DropDownBundleOption", ["createDynamicBundle"], []); // stepKey: dynamicBundleOption
		$I->createEntity("createDynamicBundleLink", "hook", "ApiBundleLink", ["createDynamicBundle", "dynamicBundleOption", "createSimpleProduct"], []); // stepKey: createDynamicBundleLink
		$I->createEntity("createSimpleProductTwo", "hook", "SimpleProductNotVisibleIndividually", [], []); // stepKey: createSimpleProductTwo
		$I->createEntity("createFixedBundle", "hook", "FixedBundleProductCustomDescription", [], []); // stepKey: createFixedBundle
		$I->createEntity("fixedBundleOption", "hook", "DropDownBundleOption", ["createFixedBundle"], []); // stepKey: fixedBundleOption
		$I->createEntity("createFixedBundleLink", "hook", "ApiBundleLink", ["createFixedBundle", "fixedBundleOption", "createSimpleProductTwo"], []); // stepKey: createFixedBundleLink
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, ""); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createDynamicBundle", "hook"); // stepKey: deleteDynamicBundleProduct
		$I->deleteEntity("createFixedBundle", "hook"); // stepKey: deleteFixedBundleProduct
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createSimpleProductTwo", "hook"); // stepKey: createSimpleProductTwo
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
	 * @Features({"Bundle"})
	 * @Stories({"Bundle products list on Storefront"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCustomerSearchBundleProductsByKeywordsTest(AcceptanceTester $I)
	{
		$I->comment("1. Go to storefront home page");
		$I->comment("Entering Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage
		$I->comment("Exiting Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("2. Fill quick search bar with test values unique for dynamic bundle product and click search");
		$I->comment("Entering Action Group [quickSearchDynamic] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "Dynamic"); // stepKey: fillInputQuickSearchDynamic
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchDynamic
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchDynamic
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchDynamic
		$I->seeInTitle("Search results for: 'Dynamic'"); // stepKey: assertQuickSearchTitleQuickSearchDynamic
		$I->see("Search results for: 'Dynamic'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchDynamic
		$I->comment("Exiting Action Group [quickSearchDynamic] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [assertDynamicBundleInSearchResultByDynamic] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->see($I->retrieveEntityField('createDynamicBundle', 'name', 'test'), "//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createDynamicBundle', 'name', 'test') . "')]]"); // stepKey: seeProductNameAssertDynamicBundleInSearchResultByDynamic
		$I->comment("Exiting Action Group [assertDynamicBundleInSearchResultByDynamic] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->comment("Entering Action Group [assertFixedBundleInSearchResultByDynamic] StorefrontQuickSearchCheckProductNameNotInGridActionGroup");
		$I->dontSee($I->retrieveEntityField('createFixedBundle', 'name', 'test'), ".column.main"); // stepKey: dontSeeProductNameAssertFixedBundleInSearchResultByDynamic
		$I->comment("Exiting Action Group [assertFixedBundleInSearchResultByDynamic] StorefrontQuickSearchCheckProductNameNotInGridActionGroup");
		$I->comment("Entering Action Group [quickSearchByDescription] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "Dynamicscription"); // stepKey: fillInputQuickSearchByDescription
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchByDescription
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchByDescription
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchByDescription
		$I->seeInTitle("Search results for: 'Dynamicscription'"); // stepKey: assertQuickSearchTitleQuickSearchByDescription
		$I->see("Search results for: 'Dynamicscription'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchByDescription
		$I->comment("Exiting Action Group [quickSearchByDescription] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [assertDynamicBundleInSearchResultByDescription] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->see($I->retrieveEntityField('createDynamicBundle', 'name', 'test'), "//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createDynamicBundle', 'name', 'test') . "')]]"); // stepKey: seeProductNameAssertDynamicBundleInSearchResultByDescription
		$I->comment("Exiting Action Group [assertDynamicBundleInSearchResultByDescription] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->comment("Entering Action Group [dontSeeFixedBundleInSearchResultByDescription] StorefrontQuickSearchCheckProductNameNotInGridActionGroup");
		$I->dontSee($I->retrieveEntityField('createFixedBundle', 'name', 'test'), ".column.main"); // stepKey: dontSeeProductNameDontSeeFixedBundleInSearchResultByDescription
		$I->comment("Exiting Action Group [dontSeeFixedBundleInSearchResultByDescription] StorefrontQuickSearchCheckProductNameNotInGridActionGroup");
		$I->comment("Entering Action Group [quickSearchShortDescription] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "Dynamictest"); // stepKey: fillInputQuickSearchShortDescription
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchShortDescription
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchShortDescription
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchShortDescription
		$I->seeInTitle("Search results for: 'Dynamictest'"); // stepKey: assertQuickSearchTitleQuickSearchShortDescription
		$I->see("Search results for: 'Dynamictest'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchShortDescription
		$I->comment("Exiting Action Group [quickSearchShortDescription] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [assertDynamicBundleInSearchResultByShortDescription] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->see($I->retrieveEntityField('createDynamicBundle', 'name', 'test'), "//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createDynamicBundle', 'name', 'test') . "')]]"); // stepKey: seeProductNameAssertDynamicBundleInSearchResultByShortDescription
		$I->comment("Exiting Action Group [assertDynamicBundleInSearchResultByShortDescription] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->comment("Entering Action Group [dontSeeFixedBundleInSearchResultByShortDescription] StorefrontQuickSearchCheckProductNameNotInGridActionGroup");
		$I->dontSee($I->retrieveEntityField('createFixedBundle', 'name', 'test'), ".column.main"); // stepKey: dontSeeProductNameDontSeeFixedBundleInSearchResultByShortDescription
		$I->comment("Exiting Action Group [dontSeeFixedBundleInSearchResultByShortDescription] StorefrontQuickSearchCheckProductNameNotInGridActionGroup");
		$I->comment("3. Fill quick search bar with test values mutual for both products and click search");
		$I->comment("Entering Action Group [quickSearchTest123] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "Test 123"); // stepKey: fillInputQuickSearchTest123
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchTest123
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchTest123
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchTest123
		$I->seeInTitle("Search results for: 'Test 123'"); // stepKey: assertQuickSearchTitleQuickSearchTest123
		$I->see("Search results for: 'Test 123'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchTest123
		$I->comment("Exiting Action Group [quickSearchTest123] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [seeDynamicBundleByTest123] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->see($I->retrieveEntityField('createDynamicBundle', 'name', 'test'), "//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createDynamicBundle', 'name', 'test') . "')]]"); // stepKey: seeProductNameSeeDynamicBundleByTest123
		$I->comment("Exiting Action Group [seeDynamicBundleByTest123] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->comment("Entering Action Group [seeFixedBundleByTest123] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->see($I->retrieveEntityField('createFixedBundle', 'name', 'test'), "//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createFixedBundle', 'name', 'test') . "')]]"); // stepKey: seeProductNameSeeFixedBundleByTest123
		$I->comment("Exiting Action Group [seeFixedBundleByTest123] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->comment("Entering Action Group [quickSearchTesting321] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "Testing 321"); // stepKey: fillInputQuickSearchTesting321
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchTesting321
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchTesting321
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchTesting321
		$I->seeInTitle("Search results for: 'Testing 321'"); // stepKey: assertQuickSearchTitleQuickSearchTesting321
		$I->see("Search results for: 'Testing 321'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchTesting321
		$I->comment("Exiting Action Group [quickSearchTesting321] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [seeDynamicBundleByTesting321] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->see($I->retrieveEntityField('createDynamicBundle', 'name', 'test'), "//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createDynamicBundle', 'name', 'test') . "')]]"); // stepKey: seeProductNameSeeDynamicBundleByTesting321
		$I->comment("Exiting Action Group [seeDynamicBundleByTesting321] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->comment("Entering Action Group [seeFixedBundleByTesting321] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->see($I->retrieveEntityField('createFixedBundle', 'name', 'test'), "//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createFixedBundle', 'name', 'test') . "')]]"); // stepKey: seeProductNameSeeFixedBundleByTesting321
		$I->comment("Exiting Action Group [seeFixedBundleByTesting321] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->comment("Entering Action Group [quickSearchShort555] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "Short 555"); // stepKey: fillInputQuickSearchShort555
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchShort555
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchShort555
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchShort555
		$I->seeInTitle("Search results for: 'Short 555'"); // stepKey: assertQuickSearchTitleQuickSearchShort555
		$I->see("Search results for: 'Short 555'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchShort555
		$I->comment("Exiting Action Group [quickSearchShort555] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [seeDynamicBundleByShort555] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->see($I->retrieveEntityField('createDynamicBundle', 'name', 'test'), "//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createDynamicBundle', 'name', 'test') . "')]]"); // stepKey: seeProductNameSeeDynamicBundleByShort555
		$I->comment("Exiting Action Group [seeDynamicBundleByShort555] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->comment("Entering Action Group [seeFixedBundleByShort555] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->see($I->retrieveEntityField('createFixedBundle', 'name', 'test'), "//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createFixedBundle', 'name', 'test') . "')]]"); // stepKey: seeProductNameSeeFixedBundleByShort555
		$I->comment("Exiting Action Group [seeFixedBundleByShort555] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->comment("4. Fill quick search bar with test values unique for fixed bundle product and click search");
		$I->comment("Entering Action Group [quickSearchByFixed] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "Fixed"); // stepKey: fillInputQuickSearchByFixed
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchByFixed
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchByFixed
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchByFixed
		$I->seeInTitle("Search results for: 'Fixed'"); // stepKey: assertQuickSearchTitleQuickSearchByFixed
		$I->see("Search results for: 'Fixed'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchByFixed
		$I->comment("Exiting Action Group [quickSearchByFixed] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [seeFixedBundleByFixed] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->see($I->retrieveEntityField('createFixedBundle', 'name', 'test'), "//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createFixedBundle', 'name', 'test') . "')]]"); // stepKey: seeProductNameSeeFixedBundleByFixed
		$I->comment("Exiting Action Group [seeFixedBundleByFixed] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->comment("Entering Action Group [dontSeeDynamicBundleByFixed] StorefrontQuickSearchCheckProductNameNotInGridActionGroup");
		$I->dontSee($I->retrieveEntityField('createDynamicBundle', 'name', 'test'), ".column.main"); // stepKey: dontSeeProductNameDontSeeDynamicBundleByFixed
		$I->comment("Exiting Action Group [dontSeeDynamicBundleByFixed] StorefrontQuickSearchCheckProductNameNotInGridActionGroup");
		$I->comment("Entering Action Group [quickSearchByDescriptionForFixed] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "Fixedscription"); // stepKey: fillInputQuickSearchByDescriptionForFixed
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchByDescriptionForFixed
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchByDescriptionForFixed
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchByDescriptionForFixed
		$I->seeInTitle("Search results for: 'Fixedscription'"); // stepKey: assertQuickSearchTitleQuickSearchByDescriptionForFixed
		$I->see("Search results for: 'Fixedscription'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchByDescriptionForFixed
		$I->comment("Exiting Action Group [quickSearchByDescriptionForFixed] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [seeFixedBundleByDescriptionForFixed] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->see($I->retrieveEntityField('createFixedBundle', 'name', 'test'), "//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createFixedBundle', 'name', 'test') . "')]]"); // stepKey: seeProductNameSeeFixedBundleByDescriptionForFixed
		$I->comment("Exiting Action Group [seeFixedBundleByDescriptionForFixed] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->comment("Entering Action Group [dontSeeDynamicProductByDescriptionForFixed] StorefrontQuickSearchCheckProductNameNotInGridActionGroup");
		$I->dontSee($I->retrieveEntityField('createDynamicBundle', 'name', 'test'), ".column.main"); // stepKey: dontSeeProductNameDontSeeDynamicProductByDescriptionForFixed
		$I->comment("Exiting Action Group [dontSeeDynamicProductByDescriptionForFixed] StorefrontQuickSearchCheckProductNameNotInGridActionGroup");
		$I->comment("Entering Action Group [quickSearchByShortDescriptionForFixed] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "Fixedtest"); // stepKey: fillInputQuickSearchByShortDescriptionForFixed
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchByShortDescriptionForFixed
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchByShortDescriptionForFixed
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchByShortDescriptionForFixed
		$I->seeInTitle("Search results for: 'Fixedtest'"); // stepKey: assertQuickSearchTitleQuickSearchByShortDescriptionForFixed
		$I->see("Search results for: 'Fixedtest'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchByShortDescriptionForFixed
		$I->comment("Exiting Action Group [quickSearchByShortDescriptionForFixed] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [seeFixedBundleByShortDescriptionForFixed] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->see($I->retrieveEntityField('createFixedBundle', 'name', 'test'), "//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createFixedBundle', 'name', 'test') . "')]]"); // stepKey: seeProductNameSeeFixedBundleByShortDescriptionForFixed
		$I->comment("Exiting Action Group [seeFixedBundleByShortDescriptionForFixed] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->comment("Entering Action Group [dontSeeDynamicBundleByShortDescriptionForFixed] StorefrontQuickSearchCheckProductNameNotInGridActionGroup");
		$I->dontSee($I->retrieveEntityField('createDynamicBundle', 'name', 'test'), ".column.main"); // stepKey: dontSeeProductNameDontSeeDynamicBundleByShortDescriptionForFixed
		$I->comment("Exiting Action Group [dontSeeDynamicBundleByShortDescriptionForFixed] StorefrontQuickSearchCheckProductNameNotInGridActionGroup");
	}
}
