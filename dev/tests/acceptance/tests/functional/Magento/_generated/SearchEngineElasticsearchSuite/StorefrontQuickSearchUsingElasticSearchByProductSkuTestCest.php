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
 * @Title("MC-31114: Check that AND query is performed when searching using ElasticSearch 7")
 * @Description("Check that AND query is performed when searching using ElasticSearch 7<h3>Test files</h3>app/code/Magento/Elasticsearch7/Test/Mftf/Test/StorefrontQuickSearchUsingElasticSearchByProductSkuTest.xml<br>")
 * @TestCaseId("MC-31114")
 * @group SearchEngineElasticsearch
 */
class StorefrontQuickSearchUsingElasticSearchByProductSkuTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [deleteAllProducts] DeleteAllProductsUsingProductGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: openAdminGridProductsPageDeleteAllProducts
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadDeleteAllProducts
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clearGridFiltersDeleteAllProducts
		$I->waitForPageLoad(30); // stepKey: clearGridFiltersDeleteAllProductsWaitForPageLoad
		$I->conditionalClick("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle", ".data-grid-tr-no-data td", false); // stepKey: openMulticheckDropdownDeleteAllProducts
		$I->conditionalClick("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']", ".data-grid-tr-no-data td", false); // stepKey: selectAllProductsInGridDeleteAllProducts
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteAllProducts
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteAllProductsWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteAllProducts
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteAllProductsWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmModalDeleteAllProducts
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteDeleteAllProducts
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteAllProductsWaitForPageLoad
		$I->waitForElementVisible(".data-grid-tr-no-data td", 30); // stepKey: waitGridIsEmptyDeleteAllProducts
		$I->comment("Exiting Action Group [deleteAllProducts] DeleteAllProductsUsingProductGridActionGroup");
		$I->createEntity("createFirtsSimpleProduct", "hook", "VirtualProduct", [], []); // stepKey: createFirtsSimpleProduct
		$I->createEntity("createSecondSimpleProduct", "hook", "SimpleProductWithCustomSku24MB06", [], []); // stepKey: createSecondSimpleProduct
		$I->createEntity("createThirdSimpleProduct", "hook", "SimpleProductWithCustomSku24MB04", [], []); // stepKey: createThirdSimpleProduct
		$I->createEntity("createFourthSimpleProduct", "hook", "SimpleProductWithCustomSku24MB02", [], []); // stepKey: createFourthSimpleProduct
		$I->createEntity("createFifthSimpleProduct", "hook", "SimpleProductWithCustomSku24MB01", [], []); // stepKey: createFifthSimpleProduct
		$I->comment("Entering Action Group [cleanCache] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanCache = $I->magentoCLI("cache:clean", 60, ""); // stepKey: cleanSpecifiedCacheCleanCache
		$I->comment($cleanSpecifiedCacheCleanCache);
		$I->comment("Exiting Action Group [cleanCache] CliCacheCleanActionGroup");
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
		$I->deleteEntity("createFirtsSimpleProduct", "hook"); // stepKey: deleteProductOne
		$I->comment("Entering Action Group [deleteAllProductsAfterTest] DeleteAllProductsUsingProductGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: openAdminGridProductsPageDeleteAllProductsAfterTest
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadDeleteAllProductsAfterTest
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clearGridFiltersDeleteAllProductsAfterTest
		$I->waitForPageLoad(30); // stepKey: clearGridFiltersDeleteAllProductsAfterTestWaitForPageLoad
		$I->conditionalClick("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle", ".data-grid-tr-no-data td", false); // stepKey: openMulticheckDropdownDeleteAllProductsAfterTest
		$I->conditionalClick("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']", ".data-grid-tr-no-data td", false); // stepKey: selectAllProductsInGridDeleteAllProductsAfterTest
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteAllProductsAfterTest
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteAllProductsAfterTestWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteAllProductsAfterTest
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteAllProductsAfterTestWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmModalDeleteAllProductsAfterTest
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteDeleteAllProductsAfterTest
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteAllProductsAfterTestWaitForPageLoad
		$I->waitForElementVisible(".data-grid-tr-no-data td", 30); // stepKey: waitGridIsEmptyDeleteAllProductsAfterTest
		$I->comment("Exiting Action Group [deleteAllProductsAfterTest] DeleteAllProductsUsingProductGridActionGroup");
		$I->comment("Entering Action Group [logoutFromAdminPanel] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdminPanel
		$I->comment("Exiting Action Group [logoutFromAdminPanel] AdminLogoutActionGroup");
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
	 * @Features({"Elasticsearch7"})
	 * @Stories({"Storefront Search"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontQuickSearchUsingElasticSearchByProductSkuTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageOpenStoreFrontHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenStoreFrontHomePage
		$I->comment("Exiting Action Group [openStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [quickSearchByProductSku] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "24 MB04"); // stepKey: fillInputQuickSearchByProductSku
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchByProductSku
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchByProductSku
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchByProductSku
		$I->seeInTitle("Search results for: '24 MB04'"); // stepKey: assertQuickSearchTitleQuickSearchByProductSku
		$I->see("Search results for: '24 MB04'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchByProductSku
		$I->comment("Exiting Action Group [quickSearchByProductSku] StorefrontCheckQuickSearchStringActionGroup");
		$I->see("4", "#toolbar-amount"); // stepKey: assertSearchResultCount
		$I->comment("Entering Action Group [assertSecondProductName] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->see($I->retrieveEntityField('createSecondSimpleProduct', 'name', 'test'), "//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createSecondSimpleProduct', 'name', 'test') . "')]]"); // stepKey: seeProductNameAssertSecondProductName
		$I->comment("Exiting Action Group [assertSecondProductName] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->comment("Entering Action Group [assertThirdProductName] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->see($I->retrieveEntityField('createThirdSimpleProduct', 'name', 'test'), "//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createThirdSimpleProduct', 'name', 'test') . "')]]"); // stepKey: seeProductNameAssertThirdProductName
		$I->comment("Exiting Action Group [assertThirdProductName] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->comment("Entering Action Group [assertFourthProductName] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->see($I->retrieveEntityField('createFourthSimpleProduct', 'name', 'test'), "//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createFourthSimpleProduct', 'name', 'test') . "')]]"); // stepKey: seeProductNameAssertFourthProductName
		$I->comment("Exiting Action Group [assertFourthProductName] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->comment("Entering Action Group [assertFifthProductName] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->see($I->retrieveEntityField('createFifthSimpleProduct', 'name', 'test'), "//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createFifthSimpleProduct', 'name', 'test') . "')]]"); // stepKey: seeProductNameAssertFifthProductName
		$I->comment("Exiting Action Group [assertFifthProductName] StorefrontQuickSearchSeeProductByNameActionGroup");
	}
}
