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
 * @Title("MC-57: Admin should be able to mass change products status")
 * @Description("Admin should be able to mass change products status<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminMassChangeProductsStatusTest.xml<br>")
 * @TestCaseId("MC-57")
 * @group Catalog
 * @group Product Attributes
 */
class AdminMassChangeProductsStatusTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProductOne", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProductOne
		$I->createEntity("createProductTwo", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProductTwo
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAmOnLogoutPage
		$I->comment("Exiting Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->deleteEntity("createProductOne", "hook"); // stepKey: deleteProductOne
		$I->deleteEntity("createProductTwo", "hook"); // stepKey: deleteProductTwo
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Features({"Catalog"})
	 * @Stories({"Mass change product status"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMassChangeProductsStatusTest(AcceptanceTester $I)
	{
		$I->comment("Search and select products");
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [searchByKeyword] SearchProductGridByKeyword2ActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialSearchByKeyword
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialSearchByKeywordWaitForPageLoad
		$I->fillField("input#fulltext", "api-simple-product"); // stepKey: fillKeywordSearchFieldSearchByKeyword
		$I->click(".data-grid-search-control-wrap button.action-submit"); // stepKey: clickKeywordSearchSearchByKeyword
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchByKeywordWaitForPageLoad
		$I->comment("Exiting Action Group [searchByKeyword] SearchProductGridByKeyword2ActionGroup");
		$I->comment("Entering Action Group [sortProductsByIdDescending] SortProductsByIdDescendingActionGroup");
		$I->conditionalClick(".//*[@class='sticky-header']/following-sibling::*//th[@class='data-grid-th _sortable _draggable _ascend']/span[text()='ID']", ".//*[@class='sticky-header']/following-sibling::*//th[@class='data-grid-th _sortable _draggable _descend']/span[text()='ID']", false); // stepKey: sortByIdSortProductsByIdDescending
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSortProductsByIdDescending
		$I->comment("Exiting Action Group [sortProductsByIdDescending] SortProductsByIdDescendingActionGroup");
		$I->click("//*[@id='container']//tr[1]/td[1]//input"); // stepKey: clickCheckbox1
		$I->click("//*[@id='container']//tr[2]/td[1]//input"); // stepKey: clickCheckbox2
		$I->comment("Mass change status");
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickDropdown
		$I->waitForPageLoad(30); // stepKey: clickDropdownWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Change status']"); // stepKey: clickChangeStatus
		$I->waitForPageLoad(30); // stepKey: clickChangeStatusWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Disable']"); // stepKey: clickDisable
		$I->waitForPageLoad(30); // stepKey: clickDisableWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForBulkUpdatePage
		$I->see("A total of 2 record(s) have been updated.", ".message.message-success.success"); // stepKey: seeAttributeUpateSuccessMsg
		$I->comment("Assert product one is not visible on storefront");
		$I->comment("Entering Action Group [GoToStorefrontAdvancedCatalogSearchProductOne] GoToStoreViewAdvancedCatalogSearchActionGroup");
		$I->amOnPage("/catalogsearch/advanced/"); // stepKey: GoToStoreViewAdvancedCatalogSearchActionGroupGoToStorefrontAdvancedCatalogSearchProductOne
		$I->waitForPageLoad(90); // stepKey: waitForPageLoadGoToStorefrontAdvancedCatalogSearchProductOne
		$I->comment("Exiting Action Group [GoToStorefrontAdvancedCatalogSearchProductOne] GoToStoreViewAdvancedCatalogSearchActionGroup");
		$I->comment("Entering Action Group [searchByNameProductOne] StorefrontAdvancedCatalogSearchByProductNameAndPriceActionGroup");
		$I->fillField("#name", $I->retrieveEntityField('createProductOne', 'name', 'test')); // stepKey: fillNameSearchByNameProductOne
		$I->fillField("#price", $I->retrieveEntityField('createProductOne', 'price', 'test') . "0"); // stepKey: fillPriceFromSearchByNameProductOne
		$I->fillField("#price_to", $I->retrieveEntityField('createProductOne', 'price', 'test') . "0"); // stepKey: fillPriceToSearchByNameProductOne
		$I->click("//*[@id='form-validate']//button[@type='submit']"); // stepKey: clickSubmitSearchByNameProductOne
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSearchByNameProductOne
		$I->comment("Exiting Action Group [searchByNameProductOne] StorefrontAdvancedCatalogSearchByProductNameAndPriceActionGroup");
		$I->comment("Entering Action Group [StorefrontCheckAdvancedSearchResultForProductOne] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->seeInCurrentUrl("/catalogsearch/advanced/result"); // stepKey: checkUrlStorefrontCheckAdvancedSearchResultForProductOne
		$I->seeInTitle("Advanced Search Results"); // stepKey: assertAdvancedSearchTitleStorefrontCheckAdvancedSearchResultForProductOne
		$I->see("Catalog Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchNameStorefrontCheckAdvancedSearchResultForProductOne
		$I->comment("Exiting Action Group [StorefrontCheckAdvancedSearchResultForProductOne] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->see("We can't find any items matching these search criteria", "div.message div"); // stepKey: seeCantFindProductOneMessage
		$I->comment("Assert product two is not visible on storefront");
		$I->comment("Entering Action Group [GoToStorefrontAdvancedCatalogSearchProductTwo] GoToStoreViewAdvancedCatalogSearchActionGroup");
		$I->amOnPage("/catalogsearch/advanced/"); // stepKey: GoToStoreViewAdvancedCatalogSearchActionGroupGoToStorefrontAdvancedCatalogSearchProductTwo
		$I->waitForPageLoad(90); // stepKey: waitForPageLoadGoToStorefrontAdvancedCatalogSearchProductTwo
		$I->comment("Exiting Action Group [GoToStorefrontAdvancedCatalogSearchProductTwo] GoToStoreViewAdvancedCatalogSearchActionGroup");
		$I->comment("Entering Action Group [searchByNameProductTwo] StorefrontAdvancedCatalogSearchByProductNameAndPriceActionGroup");
		$I->fillField("#name", $I->retrieveEntityField('createProductTwo', 'name', 'test')); // stepKey: fillNameSearchByNameProductTwo
		$I->fillField("#price", $I->retrieveEntityField('createProductTwo', 'price', 'test') . "0"); // stepKey: fillPriceFromSearchByNameProductTwo
		$I->fillField("#price_to", $I->retrieveEntityField('createProductTwo', 'price', 'test') . "0"); // stepKey: fillPriceToSearchByNameProductTwo
		$I->click("//*[@id='form-validate']//button[@type='submit']"); // stepKey: clickSubmitSearchByNameProductTwo
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSearchByNameProductTwo
		$I->comment("Exiting Action Group [searchByNameProductTwo] StorefrontAdvancedCatalogSearchByProductNameAndPriceActionGroup");
		$I->comment("Entering Action Group [StorefrontCheckAdvancedSearchResultForProductTwo] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->seeInCurrentUrl("/catalogsearch/advanced/result"); // stepKey: checkUrlStorefrontCheckAdvancedSearchResultForProductTwo
		$I->seeInTitle("Advanced Search Results"); // stepKey: assertAdvancedSearchTitleStorefrontCheckAdvancedSearchResultForProductTwo
		$I->see("Catalog Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchNameStorefrontCheckAdvancedSearchResultForProductTwo
		$I->comment("Exiting Action Group [StorefrontCheckAdvancedSearchResultForProductTwo] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->see("We can't find any items matching these search criteria", "div.message div"); // stepKey: seeCantFindProductTwoMessage
	}
}
