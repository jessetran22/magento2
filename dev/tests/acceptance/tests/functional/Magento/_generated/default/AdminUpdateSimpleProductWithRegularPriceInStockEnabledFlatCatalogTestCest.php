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
 * @Title("MC-10818: Update Simple Product with Regular Price (In Stock) Enabled Flat")
 * @Description("Test log in to Update Simple Product and Update Simple Product with Regular Price (In Stock) Enabled Flat<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminUpdateSimpleProductWithRegularPriceInStockEnabledFlatCatalogTest.xml<br>")
 * @TestCaseId("MC-10818")
 * @group catalog
 * @group mtf_migrated
 */
class AdminUpdateSimpleProductWithRegularPriceInStockEnabledFlatCatalogTestCest
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
		$setFlatCatalogProduct = $I->magentoCLI("config:set catalog/frontend/flat_catalog_product 1", 60); // stepKey: setFlatCatalogProduct
		$I->comment($setFlatCatalogProduct);
		$I->createEntity("initialCategoryEntity", "hook", "SimpleSubCategory", [], []); // stepKey: initialCategoryEntity
		$I->createEntity("initialSimpleProduct", "hook", "defaultSimpleProduct", ["initialCategoryEntity"], []); // stepKey: initialSimpleProduct
		$I->createEntity("categoryEntity", "hook", "SimpleSubCategory", [], []); // stepKey: categoryEntity
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("initialCategoryEntity", "hook"); // stepKey: deleteSimpleSubCategory
		$I->deleteEntity("categoryEntity", "hook"); // stepKey: deleteSimpleSubCategory2
		$I->comment("Entering Action Group [deleteCreatedProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteCreatedProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteCreatedProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteCreatedProduct
		$I->fillField("input.admin__control-text[name='sku']", "test_simple_product_sku" . msq("simpleProductEnabledFlat")); // stepKey: fillProductSkuFilterDeleteCreatedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteCreatedProductWaitForPageLoad
		$I->see("test_simple_product_sku" . msq("simpleProductEnabledFlat"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteCreatedProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteCreatedProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteCreatedProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteCreatedProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteCreatedProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteCreatedProduct
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteCreatedProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteCreatedProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteCreatedProductWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCreatedProduct
		$I->comment("Exiting Action Group [deleteCreatedProduct] DeleteProductBySkuActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$unsetFlatCatalogProduct = $I->magentoCLI("config:set catalog/frontend/flat_catalog_product 0", 60); // stepKey: unsetFlatCatalogProduct
		$I->comment($unsetFlatCatalogProduct);
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
	 * @Stories({"Update Simple Product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateSimpleProductWithRegularPriceInStockEnabledFlatCatalogTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openProductCatalogPage] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageOpenProductCatalogPage
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadOpenProductCatalogPage
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentOpenProductCatalogPage
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentOpenProductCatalogPageWaitForPageLoad
		$I->comment("Exiting Action Group [openProductCatalogPage] AdminClearFiltersActionGroup");
		$I->comment("Entering Action Group [openProductPage] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('initialSimpleProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenProductPage
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('initialSimpleProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] OpenEditProductOnBackendActionGroup");
		$I->comment("Entering Action Group [clickAdvancedInventoryLink] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->click("button[data-index='advanced_inventory_button'].action-additional"); // stepKey: clickOnAdvancedInventoryLinkClickAdvancedInventoryLink
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedInventoryLinkClickAdvancedInventoryLinkWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedInventoryPageToLoadClickAdvancedInventoryLink
		$I->comment("Wait for close button appeared. That means animation finished and modal window is fully visible");
		$I->waitForElementVisible(".product_form_product_form_advanced_inventory_modal button.action-close", 30); // stepKey: waitForCloseButtonAppearedClickAdvancedInventoryLink
		$I->waitForPageLoad(30); // stepKey: waitForCloseButtonAppearedClickAdvancedInventoryLinkWaitForPageLoad
		$I->comment("Exiting Action Group [clickAdvancedInventoryLink] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->comment("Entering Action Group [setManageStockConfig] AdminSetManageStockConfigActionGroup");
		$I->uncheckOption("//input[@name='product[stock_data][use_config_manage_stock]']"); // stepKey: uncheckConfigSettingSetManageStockConfig
		$I->selectOption("//*[@name='product[stock_data][manage_stock]']", "No"); // stepKey: setManageStockConfigSetManageStockConfig
		$I->waitForPageLoad(30); // stepKey: setManageStockConfigSetManageStockConfigWaitForPageLoad
		$I->comment("Exiting Action Group [setManageStockConfig] AdminSetManageStockConfigActionGroup");
		$I->comment("Entering Action Group [clickDoneButtonOnAdvancedInventorySection] AdminSubmitAdvancedInventoryFormActionGroup");
		$I->click("//aside[contains(@class,'product_form_product_form_advanced_inventory_modal')]//button[contains(@data-role,'action')]"); // stepKey: clickOnDoneButtonClickDoneButtonOnAdvancedInventorySection
		$I->waitForPageLoad(5); // stepKey: clickOnDoneButtonClickDoneButtonOnAdvancedInventorySectionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductPageToLoadClickDoneButtonOnAdvancedInventorySection
		$I->comment("Exiting Action Group [clickDoneButtonOnAdvancedInventorySection] AdminSubmitAdvancedInventoryFormActionGroup");
		$I->comment("Entering Action Group [assignCategories] AdminAssignTwoCategoriesToProductActionGroup");
		$I->comment("on edit Product page catalog/product/edit/id/\{\{product_id\}\}/");
		$I->click("div[data-index='category_ids']"); // stepKey: openDropDownAssignCategories
		$I->waitForPageLoad(30); // stepKey: openDropDownAssignCategoriesWaitForPageLoad
		$I->checkOption("//*[@data-index='category_ids']//label[contains(., '" . $I->retrieveEntityField('initialCategoryEntity', 'name', 'test') . "')]"); // stepKey: selectCategoryAssignCategories
		$I->waitForPageLoad(30); // stepKey: selectCategoryAssignCategoriesWaitForPageLoad
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickDoneAssignCategories
		$I->waitForPageLoad(30); // stepKey: clickDoneAssignCategoriesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyCategoryAssignCategories
		$I->click("div[data-index='category_ids']"); // stepKey: openDropDown2AssignCategories
		$I->waitForPageLoad(30); // stepKey: openDropDown2AssignCategoriesWaitForPageLoad
		$I->checkOption("//*[@data-index='category_ids']//label[contains(., '" . $I->retrieveEntityField('categoryEntity', 'name', 'test') . "')]"); // stepKey: selectCategoryTwoAssignCategories
		$I->waitForPageLoad(30); // stepKey: selectCategoryTwoAssignCategoriesWaitForPageLoad
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickDone2AssignCategories
		$I->waitForPageLoad(30); // stepKey: clickDone2AssignCategoriesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyCategoryTwoAssignCategories
		$I->comment("Exiting Action Group [assignCategories] AdminAssignTwoCategoriesToProductActionGroup");
		$I->comment("Entering Action Group [fillSimpleProductInfo] AdminFillMainProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillSimpleProductInfo
		$I->fillField(".admin__field[data-index=name] input", "TestSimpleProduct" . msq("simpleProductEnabledFlat")); // stepKey: fillProductNameFillSimpleProductInfo
		$I->fillField(".admin__field[data-index=sku] input", "test_simple_product_sku" . msq("simpleProductEnabledFlat")); // stepKey: fillProductSkuFillSimpleProductInfo
		$I->fillField(".admin__field[data-index=price] input", "1.99"); // stepKey: fillProductPriceFillSimpleProductInfo
		$I->fillField(".admin__field[data-index=qty] input", "1000"); // stepKey: fillProductQtyFillSimpleProductInfo
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillSimpleProductInfo
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillSimpleProductInfoWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightFillSimpleProductInfo
		$I->fillField(".admin__field[data-index=weight] input", "1"); // stepKey: fillProductWeightFillSimpleProductInfo
		$I->selectOption("//*[@name='product[tax_class_id]']", "Taxable Goods"); // stepKey: selectProductTaxClassFillSimpleProductInfo
		$I->selectOption("//select[@name='product[visibility]']", "Catalog, Search"); // stepKey: selectVisibilityFillSimpleProductInfo
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: clickAdminProductSEOSectionFillSimpleProductInfo
		$I->waitForPageLoad(30); // stepKey: clickAdminProductSEOSectionFillSimpleProductInfoWaitForPageLoad
		$I->fillField("input[name='product[url_key]']", "test-simple-product" . msq("simpleProductEnabledFlat")); // stepKey: fillUrlKeyFillSimpleProductInfo
		$I->comment("Exiting Action Group [fillSimpleProductInfo] AdminFillMainProductFormActionGroup");
		$I->comment("Entering Action Group [clickSaveButton] AdminProductFormSaveButtonClickActionGroup");
		$I->click("#save-button"); // stepKey: clickSaveButtonClickSaveButton
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavedClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminProductFormSaveButtonClickActionGroup");
		$I->see("You saved the product.", "#messages"); // stepKey: seeSimpleProductSavedSuccessMessage
		$I->comment("Entering Action Group [openProductCatalogPage1] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageOpenProductCatalogPage1
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadOpenProductCatalogPage1
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentOpenProductCatalogPage1
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentOpenProductCatalogPage1WaitForPageLoad
		$I->comment("Exiting Action Group [openProductCatalogPage1] AdminClearFiltersActionGroup");
		$I->comment("Entering Action Group [openProductPage1] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='test_simple_product_sku" . msq("simpleProductEnabledFlat") . "']]"); // stepKey: clickOnProductRowOpenProductPage1
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenProductPage1
		$I->seeInField(".admin__field[data-index=sku] input", "test_simple_product_sku" . msq("simpleProductEnabledFlat")); // stepKey: seeProductSkuOnEditProductPageOpenProductPage1
		$I->comment("Exiting Action Group [openProductPage1] OpenEditProductOnBackendActionGroup");
		$I->comment("Entering Action Group [clickTheAdvancedInventoryLink1] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->click("button[data-index='advanced_inventory_button'].action-additional"); // stepKey: clickOnAdvancedInventoryLinkClickTheAdvancedInventoryLink1
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedInventoryLinkClickTheAdvancedInventoryLink1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedInventoryPageToLoadClickTheAdvancedInventoryLink1
		$I->comment("Wait for close button appeared. That means animation finished and modal window is fully visible");
		$I->waitForElementVisible(".product_form_product_form_advanced_inventory_modal button.action-close", 30); // stepKey: waitForCloseButtonAppearedClickTheAdvancedInventoryLink1
		$I->waitForPageLoad(30); // stepKey: waitForCloseButtonAppearedClickTheAdvancedInventoryLink1WaitForPageLoad
		$I->comment("Exiting Action Group [clickTheAdvancedInventoryLink1] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->comment("Entering Action Group [assertManageStock1] AssertAdminManageStockOnEditPageActionGroup");
		$I->see("No", "//*[@name='product[stock_data][manage_stock]']"); // stepKey: seeManageStockAssertManageStock1
		$I->waitForPageLoad(30); // stepKey: seeManageStockAssertManageStock1WaitForPageLoad
		$I->comment("Exiting Action Group [assertManageStock1] AssertAdminManageStockOnEditPageActionGroup");
		$I->comment("Entering Action Group [clickDoneButtonOnAdvancedInventorySection1] AdminSubmitAdvancedInventoryFormActionGroup");
		$I->click("//aside[contains(@class,'product_form_product_form_advanced_inventory_modal')]//button[contains(@data-role,'action')]"); // stepKey: clickOnDoneButtonClickDoneButtonOnAdvancedInventorySection1
		$I->waitForPageLoad(5); // stepKey: clickOnDoneButtonClickDoneButtonOnAdvancedInventorySection1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductPageToLoadClickDoneButtonOnAdvancedInventorySection1
		$I->comment("Exiting Action Group [clickDoneButtonOnAdvancedInventorySection1] AdminSubmitAdvancedInventoryFormActionGroup");
		$I->comment("Entering Action Group [checkifProductIsAssignedToInitialCategory] AssertAdminProductIsAssignedToCategoryActionGroup");
		$I->seeElement("//*[@class='admin__action-multiselect-crumb']/span[contains(text(), '" . $I->retrieveEntityField('initialCategoryEntity', 'name', 'test') . "')]"); // stepKey: seeCategoryNameCheckifProductIsAssignedToInitialCategory
		$I->comment("Exiting Action Group [checkifProductIsAssignedToInitialCategory] AssertAdminProductIsAssignedToCategoryActionGroup");
		$I->comment("Entering Action Group [checkifProductIsAssignedToCategoryTwo] AssertAdminProductIsAssignedToCategoryActionGroup");
		$I->seeElement("//*[@class='admin__action-multiselect-crumb']/span[contains(text(), '" . $I->retrieveEntityField('categoryEntity', 'name', 'test') . "')]"); // stepKey: seeCategoryNameCheckifProductIsAssignedToCategoryTwo
		$I->comment("Exiting Action Group [checkifProductIsAssignedToCategoryTwo] AssertAdminProductIsAssignedToCategoryActionGroup");
		$I->comment("Entering Action Group [assertProductInfo] AssertAdminProductInfoOnEditPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadAssertProductInfo
		$I->seeInField(".admin__field[data-index=name] input", "TestSimpleProduct" . msq("simpleProductEnabledFlat")); // stepKey: seeProductNameAssertProductInfo
		$I->seeInField(".admin__field[data-index=sku] input", "test_simple_product_sku" . msq("simpleProductEnabledFlat")); // stepKey: seeProductSkuAssertProductInfo
		$I->seeInField(".admin__field[data-index=price] input", "1.99"); // stepKey: seeProductPriceAssertProductInfo
		$I->seeInField(".admin__field[data-index=qty] input", "1000"); // stepKey: seeProductQuantityAssertProductInfo
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: seeProductStockStatusAssertProductInfo
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusAssertProductInfoWaitForPageLoad
		$I->seeInField("//*[@name='product[tax_class_id]']", "Taxable Goods"); // stepKey: seeProductTaxClassAssertProductInfo
		$I->seeInField(".admin__field[data-index=weight] input", "1"); // stepKey: seeSimpleProductWeightAssertProductInfo
		$I->seeInField("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: seeSimpleProductWeightSelectAssertProductInfo
		$I->seeInField("//select[@name='product[visibility]']", "Catalog, Search"); // stepKey: seeVisibilityAssertProductInfo
		$I->scrollTo("div[data-index='search-engine-optimization']", 0, -80); // stepKey: scrollToAdminProductSEOSection1AssertProductInfo
		$I->waitForPageLoad(30); // stepKey: scrollToAdminProductSEOSection1AssertProductInfoWaitForPageLoad
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: clickAdminProductSEOSection1AssertProductInfo
		$I->waitForPageLoad(30); // stepKey: clickAdminProductSEOSection1AssertProductInfoWaitForPageLoad
		$I->seeInField("input[name='product[url_key]']", "test-simple-product" . msq("simpleProductEnabledFlat")); // stepKey: seeUrlKeyAssertProductInfo
		$I->comment("Exiting Action Group [assertProductInfo] AssertAdminProductInfoOnEditPageActionGroup");
		$I->comment("Entering Action Group [openCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryEntity', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageOpenCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadOpenCategoryPage
		$I->comment("Exiting Action Group [openCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Entering Action Group [seeSimpleProductNameOnCategoryPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), 'TestSimpleProduct" . msq("simpleProductEnabledFlat") . "')]", 30); // stepKey: assertProductNameSeeSimpleProductNameOnCategoryPage
		$I->comment("Exiting Action Group [seeSimpleProductNameOnCategoryPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [goToProductPage] OpenStoreFrontProductPageActionGroup");
		$I->amOnPage("/test-simple-product" . msq("simpleProductEnabledFlat") . ".html"); // stepKey: amOnProductPageGoToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadGoToProductPage
		$I->comment("Exiting Action Group [goToProductPage] OpenStoreFrontProductPageActionGroup");
		$I->comment("Entering Action Group [seeSimpleProductNameOnStoreFrontPage] StorefrontAssertProductNameOnProductPageActionGroup");
		$I->see("TestSimpleProduct" . msq("simpleProductEnabledFlat"), ".base"); // stepKey: seeProductNameSeeSimpleProductNameOnStoreFrontPage
		$I->comment("Exiting Action Group [seeSimpleProductNameOnStoreFrontPage] StorefrontAssertProductNameOnProductPageActionGroup");
		$I->comment("Entering Action Group [seeSimpleProductPriceOnStoreFrontPage] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->see("1.99", ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceSeeSimpleProductPriceOnStoreFrontPage
		$I->comment("Exiting Action Group [seeSimpleProductPriceOnStoreFrontPage] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->comment("Entering Action Group [seeSimpleProductSKUOnStoreFrontPage] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->see("test_simple_product_sku" . msq("simpleProductEnabledFlat"), ".product.attribute.sku>.value"); // stepKey: seeProductSkuSeeSimpleProductSKUOnStoreFrontPage
		$I->comment("Exiting Action Group [seeSimpleProductSKUOnStoreFrontPage] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->comment("Entering Action Group [seeSimpleProductStockStatusOnStoreFrontPage] AssertStorefrontProductStockStatusOnProductPageActionGroup");
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: seeProductStockStatusSeeSimpleProductStockStatusOnStoreFrontPage
		$I->comment("Exiting Action Group [seeSimpleProductStockStatusOnStoreFrontPage] AssertStorefrontProductStockStatusOnProductPageActionGroup");
		$I->comment("Entering Action Group [goToHomepage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomepage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomepage
		$I->comment("Exiting Action Group [goToHomepage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [searchForSku] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "test_simple_product_sku" . msq("simpleProductEnabledFlat")); // stepKey: fillInputSearchForSku
		$I->submitForm("#search", []); // stepKey: submitQuickSearchSearchForSku
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlSearchForSku
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeySearchForSku
		$I->seeInTitle("Search results for: 'test_simple_product_sku" . msq("simpleProductEnabledFlat") . "'"); // stepKey: assertQuickSearchTitleSearchForSku
		$I->see("Search results for: 'test_simple_product_sku" . msq("simpleProductEnabledFlat") . "'", ".page-title span"); // stepKey: assertQuickSearchNameSearchForSku
		$I->comment("Exiting Action Group [searchForSku] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [openAndCheckProduct] StorefrontOpenProductFromQuickSearchActionGroup");
		$I->scrollTo("//div[contains(@class, 'product-item-info') and .//*[contains(., 'TestSimpleProduct" . msq("simpleProductEnabledFlat") . "')]]"); // stepKey: scrollToProductOpenAndCheckProduct
		$I->click("//div[contains(@class, 'product-item-info') and .//*[contains(., 'TestSimpleProduct" . msq("simpleProductEnabledFlat") . "')]]"); // stepKey: openProductOpenAndCheckProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductLoadOpenAndCheckProduct
		$I->seeInCurrentUrl("test-simple-product" . msq("simpleProductEnabledFlat")); // stepKey: checkUrlOpenAndCheckProduct
		$I->see("TestSimpleProduct" . msq("simpleProductEnabledFlat"), ".base"); // stepKey: checkNameOpenAndCheckProduct
		$I->comment("Exiting Action Group [openAndCheckProduct] StorefrontOpenProductFromQuickSearchActionGroup");
	}
}
