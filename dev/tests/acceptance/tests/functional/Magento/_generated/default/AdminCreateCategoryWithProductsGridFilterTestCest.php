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
 * @Title("MC-5273: Apply category products grid filter")
 * @Description("Login as admin and create default product and product with grid filter<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateCategoryWithProductsGridFilterTest.xml<br>")
 * @TestCaseId("MC-5273")
 * @group mtf_migrated
 * @group Catalog
 */
class AdminCreateCategoryWithProductsGridFilterTestCest
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
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteCategory] DeleteCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: goToCategoryPageDeleteCategory
		$I->waitForPageLoad(60); // stepKey: waitForCategoryPageLoadDeleteCategory
		$I->click("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: clickCategoryLinkDeleteCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkDeleteCategoryWaitForPageLoad
		$I->click(".page-actions-inner #delete"); // stepKey: clickDeleteDeleteCategory
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalDeleteCategory
		$I->see("Are you sure you want to delete this category?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageDeleteCategory
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteDeleteCategory
		$I->waitForPageLoad(60); // stepKey: waitForDeleteToFinishDeleteCategory
		$I->see("You deleted the category."); // stepKey: seeDeleteSuccessDeleteCategory
		$I->click(".tree-actions a:last-child"); // stepKey: expandToSeeAllCategoriesDeleteCategory
		$I->dontSee("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: dontSeeCategoryInTreeDeleteCategory
		$I->waitForPageLoad(30); // stepKey: dontSeeCategoryInTreeDeleteCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [deleteCategory] DeleteCategoryActionGroup");
		$I->comment("Entering Action Group [deleteProduct1] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct1
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteProduct1
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteProduct1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteProduct1WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct1
		$I->fillField("input.admin__control-text[name='sku']", "testsku" . msq("defaultSimpleProduct")); // stepKey: fillProductSkuFilterDeleteProduct1
		$I->fillField("input.admin__control-text[name='name']", "Testp" . msq("defaultSimpleProduct")); // stepKey: fillProductNameFilterDeleteProduct1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct1
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProduct1WaitForPageLoad
		$I->see("testsku" . msq("defaultSimpleProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct1
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProduct1
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProduct1
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct1
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProduct1WaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct1
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProduct1WaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteProduct1
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct1
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProduct1WaitForPageLoad
		$I->comment("Exiting Action Group [deleteProduct1] DeleteProductUsingProductGridActionGroup");
		$I->comment("Entering Action Group [deleteProduct2] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct2
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteProduct2
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteProduct2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteProduct2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct2
		$I->fillField("input.admin__control-text[name='sku']", "SimpleProduct" . msq("SimpleProduct")); // stepKey: fillProductSkuFilterDeleteProduct2
		$I->fillField("input.admin__control-text[name='name']", "Simple Product " . msq("SimpleProduct")); // stepKey: fillProductNameFilterDeleteProduct2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProduct2WaitForPageLoad
		$I->see("SimpleProduct" . msq("SimpleProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct2
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProduct2
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProduct2
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct2
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProduct2WaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct2
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProduct2WaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteProduct2
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct2
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProduct2WaitForPageLoad
		$I->comment("Exiting Action Group [deleteProduct2] DeleteProductUsingProductGridActionGroup");
		$I->comment("Entering Action Group [NavigateToAndResetProductGridToDefaultView] NavigateToAndResetProductGridToDefaultViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToAdminProductIndexPageNavigateToAndResetProductGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadNavigateToAndResetProductGridToDefaultView
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersNavigateToAndResetProductGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersNavigateToAndResetProductGridToDefaultViewWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabNavigateToAndResetProductGridToDefaultView
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewNavigateToAndResetProductGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewNavigateToAndResetProductGridToDefaultViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadNavigateToAndResetProductGridToDefaultView
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedNavigateToAndResetProductGridToDefaultView
		$I->comment("Exiting Action Group [NavigateToAndResetProductGridToDefaultView] NavigateToAndResetProductGridToDefaultViewActionGroup");
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
	 * @Stories({"Create categories"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCategoryWithProductsGridFilterTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [amOnProductList] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductList
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductList
		$I->comment("Exiting Action Group [amOnProductList] AdminOpenProductIndexPageActionGroup");
		$I->comment("Create Default Product");
		$I->click("#add_new_product-button"); // stepKey: clickAddDefaultProduct
		$I->waitForPageLoad(30); // stepKey: clickAddDefaultProductWaitForPageLoad
		$I->fillField(".admin__field[data-index=name] input", "Simple Product " . msq("SimpleProduct")); // stepKey: fillDefaultProductName
		$I->fillField(".admin__field[data-index=sku] input", "SimpleProduct" . msq("SimpleProduct")); // stepKey: fillDefaultProductSku
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillDefaultProductPrice
		$I->scrollTo("//div[@data-index='search-engine-optimization']"); // stepKey: scrollToSearchEngine
		$I->click("//div[@data-index='search-engine-optimization']"); // stepKey: selectSearchEngineOptimization
		$I->fillField("//input[@name='product[url_key]']", "simple-product-" . msq("SimpleProduct")); // stepKey: fillUrlKey
		$I->waitForPageLoad(30); // stepKey: fillUrlKeyWaitForPageLoad
		$I->comment("Entering Action Group [clickSaveDefaultProduct] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveDefaultProduct
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveDefaultProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveDefaultProduct
		$I->comment("Exiting Action Group [clickSaveDefaultProduct] AdminProductFormSaveActionGroup");
		$I->see("You saved the product.", ".message-success"); // stepKey: successMessageYouSavedTheProductIsShown
		$I->comment("Create product with grid filter Not Visible Individually");
		$I->comment("Entering Action Group [ProductList] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageProductList
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadProductList
		$I->comment("Exiting Action Group [ProductList] AdminOpenProductIndexPageActionGroup");
		$I->click("#add_new_product-button"); // stepKey: clickAddFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickAddFilterProductWaitForPageLoad
		$I->fillField(".admin__field[data-index=name] input", "Testp" . msq("defaultSimpleProduct")); // stepKey: fillProductName
		$I->fillField(".admin__field[data-index=sku] input", "testsku" . msq("defaultSimpleProduct")); // stepKey: fillProductSku
		$I->fillField(".admin__field[data-index=price] input", "560.00"); // stepKey: fillProductPrice
		$I->selectOption("//*[@name='product[visibility]']", "Not Visible Individually"); // stepKey: selectProductVisibility
		$I->scrollTo("//div[@data-index='search-engine-optimization']"); // stepKey: scrollToSearchEngineOptimization
		$I->click("//div[@data-index='search-engine-optimization']"); // stepKey: selectSearchEngineOptimization1
		$I->fillField("//input[@name='product[url_key]']", "testurl-" . msq("defaultSimpleProduct")); // stepKey: fillUrlKey1
		$I->waitForPageLoad(30); // stepKey: fillUrlKey1WaitForPageLoad
		$I->comment("Entering Action Group [clickSaveProduct] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveProduct
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveProduct
		$I->comment("Exiting Action Group [clickSaveProduct] AdminProductFormSaveActionGroup");
		$I->see("You saved the product.", ".message-success"); // stepKey: messageYouSavedTheProductIsShown
		$I->comment("Entering Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Create sub category");
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategoryButton
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryButtonWaitForPageLoad
		$I->checkOption("input[name='is_active']"); // stepKey: enableCategory
		$I->fillField("input[name='name']", "simpleCategory" . msq("_defaultCategory")); // stepKey: fillCategoryName
		$I->comment("Select the default product and product with grid filter");
		$I->scrollTo("div[data-index='assign_products']", 0, -80); // stepKey: scrollToProductInCategory
		$I->waitForPageLoad(30); // stepKey: scrollToProductInCategoryWaitForPageLoad
		$I->click("div[data-index='assign_products']"); // stepKey: clickOnProductInCategory
		$I->waitForPageLoad(30); // stepKey: clickOnProductInCategoryWaitForPageLoad
		$I->fillField("#catalog_category_products_filter_name", "Simple Product " . msq("SimpleProduct")); // stepKey: selectProduct
		$I->click("//button[@data-action='grid-filter-apply']"); // stepKey: clickSearchButton
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonWaitForPageLoad
		$I->click("#catalog_category_products_table tbody tr"); // stepKey: selectProductFromRow
		$I->fillField("#catalog_category_products_filter_name", "Testp" . msq("defaultSimpleProduct")); // stepKey: selectDefaultProduct
		$I->click("//button[@data-action='grid-filter-apply']"); // stepKey: clickSearchButton1
		$I->waitForPageLoad(30); // stepKey: clickSearchButton1WaitForPageLoad
		$I->click("#catalog_category_products_table tbody tr"); // stepKey: selectDefaultProductFromTableRow
		$I->comment("Entering Action Group [clickSaveButton] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsClickSaveButton
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminSaveCategoryActionGroup");
		$I->comment("Entering Action Group [successMessageYouSavedTheCategory] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForElementSuccessMessageYouSavedTheCategory
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: seeSuccessMessageSuccessMessageYouSavedTheCategory
		$I->comment("Exiting Action Group [successMessageYouSavedTheCategory] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->comment("Verify product with grid filter is not not visible");
		$I->amOnPage("/testurl-" . msq("defaultSimpleProduct") . ".html"); // stepKey: seeOnProductPage
		$I->waitForPageLoad(30); // stepKey: waitForStoreFrontProductPageToLoad
		$I->dontSee("Testp" . msq("defaultSimpleProduct"), ".base"); // stepKey: dontSeeProductInStoreFrontPage
		$I->comment("Verify product in Store Front Page");
		$I->amOnPage("/simple-product-" . msq("SimpleProduct") . ".html"); // stepKey: seeDefaultProductPage
		$I->waitForPageLoad(30); // stepKey: waitForStoreFrontProductPageToLoad1
		$I->see("Simple Product " . msq("SimpleProduct"), ".base"); // stepKey: seeProductInStoreFrontPage
	}
}
