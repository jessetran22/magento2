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
 * @Title("MAGETWO-95085: Grouped Products: Sorting Associated Products Between Pages")
 * @Description("Make sure that products in grid were recalculated when sorting associated products between pages<h3>Test files</h3>app/code/Magento/GroupedProduct/Test/Mftf/Test/AdminSortingAssociatedProductsTest.xml<br>")
 * @TestCaseId("MAGETWO-95085")
 * @group GroupedProduct
 */
class AdminSortingAssociatedProductsTestCest
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
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->createEntity("category", "hook", "_defaultCategory", [], []); // stepKey: category
		$I->comment("Create 23 products so that grid can have more than one page");
		$I->createEntity("product1", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product1
		$I->createEntity("product2", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product2
		$I->createEntity("product3", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product3
		$I->createEntity("product4", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product4
		$I->createEntity("product5", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product5
		$I->createEntity("product6", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product6
		$I->createEntity("product7", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product7
		$I->createEntity("product8", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product8
		$I->createEntity("product9", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product9
		$I->createEntity("product10", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product10
		$I->createEntity("product11", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product11
		$I->createEntity("product12", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product12
		$I->createEntity("product13", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product13
		$I->createEntity("product14", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product14
		$I->createEntity("product15", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product15
		$I->createEntity("product16", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product16
		$I->createEntity("product17", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product17
		$I->createEntity("product18", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product18
		$I->createEntity("product19", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product19
		$I->createEntity("product20", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product20
		$I->createEntity("product21", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product21
		$I->createEntity("product22", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product22
		$I->createEntity("product23", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product23
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created grouped product");
		$I->comment("Entering Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct
		$I->fillField("input.admin__control-text[name='sku']", "groupedproduct" . msq("GroupedProduct")); // stepKey: fillProductSkuFilterDeleteProduct
		$I->fillField("input.admin__control-text[name='name']", "GroupedProduct" . msq("GroupedProduct")); // stepKey: fillProductNameFilterDeleteProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProductWaitForPageLoad
		$I->see("groupedproduct" . msq("GroupedProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProductWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteProduct
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProductWaitForPageLoad
		$I->comment("Exiting Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersWaitForPageLoad
		$I->deleteEntity("product1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("product2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("product3", "hook"); // stepKey: deleteProduct3
		$I->deleteEntity("product4", "hook"); // stepKey: deleteProduct4
		$I->deleteEntity("product5", "hook"); // stepKey: deleteProduct5
		$I->deleteEntity("product6", "hook"); // stepKey: deleteProduct6
		$I->deleteEntity("product7", "hook"); // stepKey: deleteProduct7
		$I->deleteEntity("product8", "hook"); // stepKey: deleteProduct8
		$I->deleteEntity("product9", "hook"); // stepKey: deleteProduct9
		$I->deleteEntity("product10", "hook"); // stepKey: deleteProduct10
		$I->deleteEntity("product11", "hook"); // stepKey: deleteProduct11
		$I->deleteEntity("product12", "hook"); // stepKey: deleteProduct12
		$I->deleteEntity("product13", "hook"); // stepKey: deleteProduct13
		$I->deleteEntity("product14", "hook"); // stepKey: deleteProduct14
		$I->deleteEntity("product15", "hook"); // stepKey: deleteProduct15
		$I->deleteEntity("product16", "hook"); // stepKey: deleteProduct16
		$I->deleteEntity("product17", "hook"); // stepKey: deleteProduct17
		$I->deleteEntity("product18", "hook"); // stepKey: deleteProduct18
		$I->deleteEntity("product19", "hook"); // stepKey: deleteProduct19
		$I->deleteEntity("product20", "hook"); // stepKey: deleteProduct20
		$I->deleteEntity("product21", "hook"); // stepKey: deleteProduct21
		$I->deleteEntity("product22", "hook"); // stepKey: deleteProduct22
		$I->deleteEntity("product23", "hook"); // stepKey: deleteProduct23
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Features({"GroupedProduct"})
	 * @Stories({"MAGETWO-91633: Grouped Products: Associated Products Can't Be Sorted Between Pages"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminSortingAssociatedProductsTest(AcceptanceTester $I)
	{
		$I->comment("Create grouped Product");
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [resetProductGridColumnsInitial] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetProductGridColumnsInitial
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetProductGridColumnsInitialWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetProductGridColumnsInitial
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetProductGridColumnsInitial
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetProductGridColumnsInitialWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetProductGridColumnsInitial
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetProductGridColumnsInitial
		$I->comment("Exiting Action Group [resetProductGridColumnsInitial] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [goToCreateProduct] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleGoToCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleGoToCreateProductWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-grouped']", 30); // stepKey: waitForAddProductDropdownGoToCreateProduct
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-grouped']"); // stepKey: clickAddProductTypeGoToCreateProduct
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadGoToCreateProduct
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/grouped/"); // stepKey: seeNewProductUrlGoToCreateProduct
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleGoToCreateProduct
		$I->comment("Exiting Action Group [goToCreateProduct] GoToCreateProductPageActionGroup");
		$I->comment("Entering Action Group [fillProductForm] FillGroupedProductFormActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "GroupedProduct" . msq("GroupedProduct")); // stepKey: fillProductSkuFillProductForm
		$I->fillField(".admin__field[data-index=sku] input", "groupedproduct" . msq("GroupedProduct")); // stepKey: fillProductNameFillProductForm
		$I->comment("Exiting Action Group [fillProductForm] FillGroupedProductFormActionGroup");
		$I->scrollTo("div[data-index=grouped] .admin__collapsible-title", 0, -100); // stepKey: scrollToGroupedSection
		$I->conditionalClick("div[data-index=grouped] .admin__collapsible-title", "button[data-index='grouped_products_button']", false); // stepKey: openGroupedProductsSection
		$I->waitForPageLoad(30); // stepKey: openGroupedProductsSectionWaitForPageLoad
		$I->click("body"); // stepKey: clickBodyToCorrectFocusGrouped
		$I->click("button[data-index='grouped_products_button']"); // stepKey: clickAddProductsToGroup
		$I->waitForPageLoad(30); // stepKey: clickAddProductsToGroupWaitForPageLoad
		$I->waitForElementVisible(".product_form_product_form_grouped_grouped_products_modal [data-action='grid-filter-expand']", 30); // stepKey: waitForGroupedProductModal
		$I->waitForPageLoad(30); // stepKey: waitForGroupedProductModalWaitForPageLoad
		$I->comment("Entering Action Group [filterGroupedProducts] FilterProductGridBySku2ActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterGroupedProducts
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterGroupedProductsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterGroupedProducts
		$I->fillField("input.admin__control-text[name='sku']", "api-simple-product"); // stepKey: fillProductSkuFilterFilterGroupedProducts
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterGroupedProducts
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterGroupedProductsWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterGroupedProducts
		$I->comment("Exiting Action Group [filterGroupedProducts] FilterProductGridBySku2ActionGroup");
		$I->comment("Select all, then start the bulk update attributes flow");
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdown
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGrid
		$I->click(".product_form_product_form_grouped_grouped_products_modal button.action-primary"); // stepKey: clickAddSelectedGroupProducts
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedGroupProductsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductsAdded
		$I->comment("Entering Action Group [saveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormActionGroup");
		$I->comment("Open created Product group");
		$I->comment("Entering Action Group [goToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageGoToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadGoToProductIndex
		$I->comment("Exiting Action Group [goToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [resetFiltersIfExist] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetFiltersIfExist
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetFiltersIfExistWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetFiltersIfExist
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetFiltersIfExist
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetFiltersIfExistWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetFiltersIfExist
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetFiltersIfExist
		$I->comment("Exiting Action Group [resetFiltersIfExist] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [searchProductGridForm] SearchProductGridByKeywordActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialSearchProductGridForm
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialSearchProductGridFormWaitForPageLoad
		$I->fillField("input#fulltext", "GroupedProduct" . msq("GroupedProduct")); // stepKey: fillKeywordSearchFieldSearchProductGridForm
		$I->click(".data-grid-search-control-wrap button.action-submit"); // stepKey: clickKeywordSearchSearchProductGridForm
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchProductGridFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSearchSearchProductGridForm
		$I->comment("Exiting Action Group [searchProductGridForm] SearchProductGridByKeywordActionGroup");
		$I->click("//td/div[text()='GroupedProduct" . msq("GroupedProduct") . "']"); // stepKey: openGroupedProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductEditPageLoad
		$I->scrollTo("div[data-index=grouped] .admin__collapsible-title", 0, -100); // stepKey: scrollToGroupedSection2
		$I->conditionalClick("div[data-index=grouped] .admin__collapsible-title", "button[data-index='grouped_products_button']", false); // stepKey: openGroupedProductsSection2
		$I->waitForPageLoad(30); // stepKey: openGroupedProductsSection2WaitForPageLoad
		$I->comment("Change position value for the Product Position 0");
		$grabNameProductPosition0 = $I->grabTextFrom("//tbody/tr[1][contains(@class,'data-row')]/td[4]//*[@class='admin__field-control']//span"); // stepKey: grabNameProductPosition0
		$grabNameProductPositionFirst = $I->grabTextFrom("//tbody/tr[2][contains(@class,'data-row')]/td[4]//*[@class='admin__field-control']//span"); // stepKey: grabNameProductPositionFirst
		$I->fillField("//tbody/tr[1][contains(@class,'data-row')]/td[10]//input[@class='position-widget-input']", "21"); // stepKey: fillFieldProductPosition0
		$I->doubleClick("//*[@data-index='grouped']//*[@class='action-next']"); // stepKey: clickButton
		$I->waitForAjaxLoad(30); // stepKey: waitForAjax1
		$I->comment("Go to next page and verify that Products in grid were recalculated");
		$I->doubleClick("//*[@data-index='grouped']//*[@class='action-next']"); // stepKey: clickNextActionButton
		$I->waitForAjaxLoad(30); // stepKey: waitForAjax2
		$grabNameProductPosition21 = $I->grabTextFrom("//tbody/tr[2][contains(@class,'data-row')]/td[4]//*[@class='admin__field-control']//span"); // stepKey: grabNameProductPosition21
		$I->assertEquals("$grabNameProductPosition21", "$grabNameProductPosition0"); // stepKey: assertProductsRecalculated
		$I->comment("Change position value for the product to 1");
		$I->fillField("//tbody/tr[2][contains(@class,'data-row')]/td[10]//input[@class='position-widget-input']", "1"); // stepKey: fillFieldProductPosition1
		$I->doubleClick("//*[@data-index='grouped']//*[@class='action-previous']"); // stepKey: clickButton2
		$I->waitForAjaxLoad(30); // stepKey: waitForAjax3
		$I->comment("Go to previous page and verify that Products in grid were recalculated");
		$I->click("//*[@data-index='grouped']//*[@class='action-previous']"); // stepKey: clickPreviousActionButton
		$I->waitForAjaxLoad(30); // stepKey: waitForAjax4
		$grabNameProductPosition2 = $I->grabTextFrom("//tbody/tr[2][contains(@class,'data-row')]/td[4]//*[@class='admin__field-control']//span"); // stepKey: grabNameProductPosition2
		$grabNameProductPositionZero = $I->grabTextFrom("//tbody/tr[1][contains(@class,'data-row')]/td[4]//*[@class='admin__field-control']//span"); // stepKey: grabNameProductPositionZero
		$I->assertEquals("$grabNameProductPosition0", "$grabNameProductPosition2"); // stepKey: assertProductsRecalculated2
		$I->assertEquals("$grabNameProductPositionZero", "$grabNameProductPositionFirst"); // stepKey: assertProductsRecalculated3
	}
}
