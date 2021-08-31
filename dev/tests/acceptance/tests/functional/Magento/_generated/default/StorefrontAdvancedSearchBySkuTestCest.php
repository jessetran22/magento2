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
 * @Title("MAGETWO-24729: Search product in advanced search by sku")
 * @Description("Search product in advanced search by sku<h3>Test files</h3>app/code/Magento/CatalogSearch/Test/Mftf/Test/StorefrontAdvancedSearchBySkuTest.xml<br>")
 * @TestCaseId("MAGETWO-24729")
 * @group searchFrontend
 * @group mtf_migrated
 */
class StorefrontAdvancedSearchBySkuTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Delete all products left by prev tests because it sensitive for search");
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
		$I->comment("Create Data");
		$I->createEntity("createProduct", "hook", "ABC_dfj_SimpleProduct", [], []); // stepKey: createProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete data");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [logoutAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAdmin
		$I->comment("Exiting Action Group [logoutAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"Use Advanced Search"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"CatalogSearch"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontAdvancedSearchBySkuTest(AcceptanceTester $I)
	{
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [flushCache] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushCache = $I->magentoCLI("cache:flush", 60, ""); // stepKey: flushSpecifiedCacheFlushCache
		$I->comment($flushSpecifiedCacheFlushCache);
		$I->comment("Exiting Action Group [flushCache] CliCacheFlushActionGroup");
		$I->comment("1. Navigate to Frontend");
		$I->comment("Entering Action Group [goToStorefront] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStorefront
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStorefront
		$I->comment("Exiting Action Group [goToStorefront] StorefrontOpenHomePageActionGroup");
		$I->comment("2. Click \"Advanced Search\"");
		$I->comment("Entering Action Group [openAdvancedSearch] StorefrontOpenAdvancedSearchActionGroup");
		$I->click("//footer//ul//li//a[text()='Advanced Search']"); // stepKey: clickAdvancedSearchLinkOpenAdvancedSearch
		$I->seeInCurrentUrl("/catalogsearch/advanced/"); // stepKey: checkUrlOpenAdvancedSearch
		$I->seeInTitle("Advanced Search"); // stepKey: assertAdvancedSearchTitle1OpenAdvancedSearch
		$I->see("Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchTitle2OpenAdvancedSearch
		$I->comment("Exiting Action Group [openAdvancedSearch] StorefrontOpenAdvancedSearchActionGroup");
		$I->comment("3. Fill test data in to field(s) 4. Click \"Search\" button");
		$I->comment("Entering Action Group [search] StorefrontFillFormAdvancedSearchActionGroup");
		$I->fillField("#name", ""); // stepKey: fillNameSearch
		$I->fillField("#sku", "abc_dfj"); // stepKey: fillSkuSearch
		$I->fillField("#description", ""); // stepKey: fillDescriptionSearch
		$I->fillField("#short_description", ""); // stepKey: fillShortDescriptionSearch
		$I->fillField("#price", ""); // stepKey: fillPriceFromSearch
		$I->fillField("#price_to", ""); // stepKey: fillPriceToSearch
		$I->scrollTo("//*[@id='form-validate']//button[@type='submit']"); // stepKey: scrollToSubmitButtonSearch
		$I->click("//*[@id='form-validate']//button[@type='submit']"); // stepKey: clickSubmitSearch
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSearch
		$I->comment("Exiting Action Group [search] StorefrontFillFormAdvancedSearchActionGroup");
		$I->comment("5. Perform all asserts");
		$I->comment("Entering Action Group [StorefrontCheckAdvancedSearchResult] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->seeInCurrentUrl("/catalogsearch/advanced/result"); // stepKey: checkUrlStorefrontCheckAdvancedSearchResult
		$I->seeInTitle("Advanced Search Results"); // stepKey: assertAdvancedSearchTitleStorefrontCheckAdvancedSearchResult
		$I->see("Catalog Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchNameStorefrontCheckAdvancedSearchResult
		$I->comment("Exiting Action Group [StorefrontCheckAdvancedSearchResult] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->see("1 item", ".search.found>strong"); // stepKey: see
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), ".product.name.product-item-name>a"); // stepKey: seeProductName
	}
}
