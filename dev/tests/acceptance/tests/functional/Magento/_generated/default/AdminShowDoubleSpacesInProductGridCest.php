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
 * @Title("MC-40725: Show double spaces in the product grid")
 * @Description("Admin should be able to see double spaces in the Name and Sku fields in the product grid<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminShowDoubleSpacesInProductGrid.xml<br>")
 * @TestCaseId("MC-40725")
 * @group Catalog
 */
class AdminShowDoubleSpacesInProductGridCest
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
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "ApiSimpleProductWithDoubleSpaces", ["createCategory"], []); // stepKey: createProduct
		$cronRun = $I->magentoCLI("cron:run --group=index", 60); // stepKey: cronRun
		$I->comment($cronRun);
		$cronRunSecondTime = $I->magentoCLI("cron:run --group=index", 60); // stepKey: cronRunSecondTime
		$I->comment($cronRunSecondTime);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteProduct] AdminDeleteAllProductsFromGridActionGroup");
		$I->click("//div[@data-role='grid-wrapper']//label[@data-bind='attr: {for: ko.uid}']"); // stepKey: selectAllProductsDeleteProduct
		$I->waitForPageLoad(30); // stepKey: selectAllProductsDeleteProductWaitForPageLoad
		$I->click("//div[@class='action-select-wrap']/button"); // stepKey: clickOnActionsChangingViewDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickOnActionsChangingViewDeleteProductWaitForPageLoad
		$I->click("//div[@class='action-menu-items']//li[1]"); // stepKey: clickDeleteDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteProductWaitForPageLoad
		$I->click("//button[@class='action-primary action-accept']"); // stepKey: confirmDeleteDeleteProduct
		$I->waitForPageLoad(30); // stepKey: waitingProductGridLoadDeleteProduct
		$I->comment("Exiting Action Group [deleteProduct] AdminDeleteAllProductsFromGridActionGroup");
		$I->comment("Entering Action Group [clearGridFilters] ClearFiltersAdminProductGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersClearGridFilters
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersClearGridFiltersWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadClearGridFilters
		$I->comment("Exiting Action Group [clearGridFilters] ClearFiltersAdminProductGridActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"Edit products"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminShowDoubleSpacesInProductGrid(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [goToProductCatalogPage] AdminOpenCatalogProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openCatalogProductPageGoToProductCatalogPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToProductCatalogPage
		$I->comment("Exiting Action Group [goToProductCatalogPage] AdminOpenCatalogProductPageActionGroup");
		$I->comment("Entering Action Group [searchForProduct] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchForProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchForProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersSearchForProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterSearchForProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersSearchForProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersSearchForProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadSearchForProduct
		$I->comment("Exiting Action Group [searchForProduct] FilterProductGridBySkuActionGroup");
		$I->comment("Entering Action Group [assertProductName] AssertAdminProductGridCellActionGroup");
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Name']/preceding-sibling::th) +1 ]"); // stepKey: seeProductGridCellWithProvidedValueAssertProductName
		$I->comment("Exiting Action Group [assertProductName] AssertAdminProductGridCellActionGroup");
		$I->comment("Entering Action Group [assertProductSku] AssertAdminProductGridCellActionGroup");
		$I->see($I->retrieveEntityField('createProduct', 'sku', 'test'), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductGridCellWithProvidedValueAssertProductSku
		$I->comment("Exiting Action Group [assertProductSku] AssertAdminProductGridCellActionGroup");
	}
}
