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
 * @Title("MC-10805: Update Simple Product with Regular Price (In Stock) Visible in Search Only")
 * @Description("Test log in to Update Simple Product and Update Simple Product with Regular Price (In Stock) Visible in Search Only<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminUpdateSimpleProductWithRegularPriceInStockVisibleInSearchOnlyTest.xml<br>")
 * @TestCaseId("MC-10805")
 * @group catalog
 * @group mtf_migrated
 */
class AdminUpdateSimpleProductWithRegularPriceInStockVisibleInSearchOnlyTestCest
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
		$I->fillField("input.admin__control-text[name='sku']", "test_simple_product_sku" . msq("simpleProductRegularPrice325InStock")); // stepKey: fillProductSkuFilterDeleteCreatedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteCreatedProductWaitForPageLoad
		$I->see("test_simple_product_sku" . msq("simpleProductRegularPrice325InStock"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteCreatedProduct
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
	public function AdminUpdateSimpleProductWithRegularPriceInStockVisibleInSearchOnlyTest(AcceptanceTester $I)
	{
		$I->comment("Search default simple product in the grid");
		$I->comment("Entering Action Group [openProductCatalogPage] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageOpenProductCatalogPage
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadOpenProductCatalogPage
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentOpenProductCatalogPage
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentOpenProductCatalogPageWaitForPageLoad
		$I->comment("Exiting Action Group [openProductCatalogPage] AdminClearFiltersActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickFirstRowToOpenDefaultSimpleProduct] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('initialSimpleProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowClickFirstRowToOpenDefaultSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadClickFirstRowToOpenDefaultSimpleProduct
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('initialSimpleProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageClickFirstRowToOpenDefaultSimpleProduct
		$I->comment("Exiting Action Group [clickFirstRowToOpenDefaultSimpleProduct] OpenEditProductOnBackendActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Update simple product with regular price(in stock)");
		$I->fillField(".admin__field[data-index=name] input", "TestSimpleProduct" . msq("simpleProductRegularPrice325InStock")); // stepKey: fillSimpleProductName
		$I->fillField(".admin__field[data-index=sku] input", "test_simple_product_sku" . msq("simpleProductRegularPrice325InStock")); // stepKey: fillSimpleProductSku
		$I->fillField(".admin__field[data-index=price] input", "325.02"); // stepKey: fillSimpleProductPrice
		$I->fillField(".admin__field[data-index=qty] input", "89"); // stepKey: fillSimpleProductQuantity
		$I->selectOption("[data-index='product-details'] select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: selectStockStatusInStock
		$I->fillField(".admin__field[data-index=weight] input", "89"); // stepKey: fillSimpleProductWeight
		$I->click("div[data-index='category_ids']"); // stepKey: clickCategoriesDropDown
		$I->waitForPageLoad(30); // stepKey: clickCategoriesDropDownWaitForPageLoad
		$I->fillField("//*[@data-index='category_ids']//input[contains(@class, 'multiselect-search')]", $I->retrieveEntityField('initialCategoryEntity', 'name', 'test')); // stepKey: fillSearchForInitialCategory
		$I->waitForPageLoad(30); // stepKey: fillSearchForInitialCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategory1
		$I->click("//*[@data-index='category_ids']//label[contains(., '" . $I->retrieveEntityField('initialCategoryEntity', 'name', 'test') . "')]"); // stepKey: unselectInitialCategory
		$I->waitForPageLoad(30); // stepKey: unselectInitialCategoryWaitForPageLoad
		$I->fillField("//*[@data-index='category_ids']//input[contains(@class, 'multiselect-search')]", $I->retrieveEntityField('categoryEntity', 'name', 'test')); // stepKey: fillSearchCategory
		$I->waitForPageLoad(30); // stepKey: fillSearchCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategory2
		$I->click("//*[@data-index='category_ids']//label[contains(., '" . $I->retrieveEntityField('categoryEntity', 'name', 'test') . "')]"); // stepKey: clickOnCategory
		$I->waitForPageLoad(30); // stepKey: clickOnCategoryWaitForPageLoad
		$I->comment("Entering Action Group [clickOnDoneAdvancedCategorySelect] AdminSubmitCategoriesPopupActionGroup");
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickOnDoneButtonClickOnDoneAdvancedCategorySelect
		$I->waitForPageLoad(30); // stepKey: clickOnDoneButtonClickOnDoneAdvancedCategorySelectWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryApplyClickOnDoneAdvancedCategorySelect
		$I->comment("Exiting Action Group [clickOnDoneAdvancedCategorySelect] AdminSubmitCategoriesPopupActionGroup");
		$I->selectOption("//select[@name='product[visibility]']", "Search"); // stepKey: selectVisibility
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: clickAdminProductSEOSection
		$I->waitForPageLoad(30); // stepKey: clickAdminProductSEOSectionWaitForPageLoad
		$I->fillField("input[name='product[url_key]']", "test-simple-product" . msq("simpleProductRegularPrice325InStock")); // stepKey: fillUrlKey
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfAdminProductFormSection
		$I->comment("Entering Action Group [clickSaveButton] AdminProductFormSaveButtonClickActionGroup");
		$I->click("#save-button"); // stepKey: clickSaveButtonClickSaveButton
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavedClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminProductFormSaveButtonClickActionGroup");
		$I->comment("Verify customer see success message");
		$I->see("You saved the product.", "#messages"); // stepKey: seeAssertSimpleProductSaveSuccessMessage
		$I->comment("Search updated simple product(from above step) in the grid page");
		$I->comment("Entering Action Group [openProductCatalogPageToSearchUpdatedSimpleProduct] AdminProductCatalogPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openProductCatalogPageOpenProductCatalogPageToSearchUpdatedSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadOpenProductCatalogPageToSearchUpdatedSimpleProduct
		$I->comment("Exiting Action Group [openProductCatalogPageToSearchUpdatedSimpleProduct] AdminProductCatalogPageOpenActionGroup");
		$I->conditionalClick(".admin__data-grid-header .admin__data-grid-filters-current._show .action-clear", ".admin__data-grid-header .admin__data-grid-filters-current._show .action-clear", true); // stepKey: clickClearAll
		$I->waitForPageLoad(30); // stepKey: clickClearAllWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersButton
		$I->fillField("input.admin__control-text[name='name']", "TestSimpleProduct" . msq("simpleProductRegularPrice325InStock")); // stepKey: fillSimpleProductNameInNameFilter
		$I->fillField("input.admin__control-text[name='sku']", "test_simple_product_sku" . msq("simpleProductRegularPrice325InStock")); // stepKey: fillProductSku
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButton
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonWaitForPageLoad
		$I->click(".data-row:nth-of-type(1)"); // stepKey: clickFirstRowToVerifyUpdatedSimpleProductVisibleInGrid
		$I->waitForPageLoad(30); // stepKey: clickFirstRowToVerifyUpdatedSimpleProductVisibleInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitUntilSimpleProductPageIsOpened
		$I->comment("Verify customer see updated simple product in the product form page");
		$I->seeInField(".admin__field[data-index=name] input", "TestSimpleProduct" . msq("simpleProductRegularPrice325InStock")); // stepKey: seeSimpleProductName
		$I->seeInField(".admin__field[data-index=sku] input", "test_simple_product_sku" . msq("simpleProductRegularPrice325InStock")); // stepKey: seeSimpleProductSku
		$I->seeInField(".admin__field[data-index=price] input", "325.02"); // stepKey: seeSimpleProductPrice
		$I->seeInField(".admin__field[data-index=qty] input", "89"); // stepKey: seeSimpleProductQuantity
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeSimpleProductStockStatus
		$I->waitForPageLoad(30); // stepKey: seeSimpleProductStockStatusWaitForPageLoad
		$I->seeInField(".admin__field[data-index=weight] input", "89"); // stepKey: seeSimpleProductWeight
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [selectedCategories] AssertAdminProductIsAssignedToCategoryActionGroup");
		$I->seeElement("//*[@class='admin__action-multiselect-crumb']/span[contains(text(), '" . $I->retrieveEntityField('categoryEntity', 'name', 'test') . "')]"); // stepKey: seeCategoryNameSelectedCategories
		$I->comment("Exiting Action Group [selectedCategories] AssertAdminProductIsAssignedToCategoryActionGroup");
		$I->seeInField("//select[@name='product[visibility]']", "Search"); // stepKey: seeVisibility
		$I->scrollTo("div[data-index='search-engine-optimization']", 0, -80); // stepKey: scrollToAdminProductSEOSection1
		$I->waitForPageLoad(30); // stepKey: scrollToAdminProductSEOSection1WaitForPageLoad
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: clickAdminProductSEOSection1
		$I->waitForPageLoad(30); // stepKey: clickAdminProductSEOSection1WaitForPageLoad
		$I->seeInField("input[name='product[url_key]']", "test-simple-product" . msq("simpleProductRegularPrice325InStock")); // stepKey: seeUrlKey
		$I->comment("Verify customer don't see updated simple product link on category page");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryEntity', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoad
		$I->dontSee("TestSimpleProduct" . msq("simpleProductRegularPrice325InStock"), "a.product-item-link"); // stepKey: dontSeeSimpleProductNameOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: dontSeeSimpleProductNameOnCategoryPageWaitForPageLoad
		$I->comment("Verify customer see updated simple product (from the above step) on the storefront page");
		$I->comment("Entering Action Group [goToProductPage] OpenStoreFrontProductPageActionGroup");
		$I->amOnPage("/test-simple-product" . msq("simpleProductRegularPrice325InStock") . ".html"); // stepKey: amOnProductPageGoToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadGoToProductPage
		$I->comment("Exiting Action Group [goToProductPage] OpenStoreFrontProductPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibilityr");
		$I->comment("Entering Action Group [seeSimpleProductNameOnStoreFrontPage] StorefrontAssertProductNameOnProductPageActionGroup");
		$I->see("TestSimpleProduct" . msq("simpleProductRegularPrice325InStock"), ".base"); // stepKey: seeProductNameSeeSimpleProductNameOnStoreFrontPage
		$I->comment("Exiting Action Group [seeSimpleProductNameOnStoreFrontPage] StorefrontAssertProductNameOnProductPageActionGroup");
		$I->comment("Entering Action Group [seeSimpleProductPriceOnStoreFrontPage] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->see("325.02", ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceSeeSimpleProductPriceOnStoreFrontPage
		$I->comment("Exiting Action Group [seeSimpleProductPriceOnStoreFrontPage] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->comment("Entering Action Group [seeProductSku] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->see("test_simple_product_sku" . msq("simpleProductRegularPrice325InStock"), ".product.attribute.sku>.value"); // stepKey: seeProductSkuSeeProductSku
		$I->comment("Exiting Action Group [seeProductSku] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibilityr");
		$I->comment("Entering Action Group [assertStockAvailableOnProductPage] AssertStorefrontProductStockStatusOnProductPageActionGroup");
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: seeProductStockStatusAssertStockAvailableOnProductPage
		$I->comment("Exiting Action Group [assertStockAvailableOnProductPage] AssertStorefrontProductStockStatusOnProductPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibilityr");
		$I->comment("Comment is added to preserve the step key for backward compatibilityr");
		$I->comment("Verify customer see updated simple product link on magento storefront page and is searchable by sku");
		$I->amOnPage("/test-simple-product" . msq("simpleProductRegularPrice325InStock") . ".html"); // stepKey: goToMagentoStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStoreFrontProductPageLoad
		$I->comment("Entering Action Group [fillSimpleProductSkuInSearchTextBox] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "test_simple_product_sku" . msq("simpleProductRegularPrice325InStock")); // stepKey: fillInputFillSimpleProductSkuInSearchTextBox
		$I->submitForm("#search", []); // stepKey: submitQuickSearchFillSimpleProductSkuInSearchTextBox
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlFillSimpleProductSkuInSearchTextBox
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyFillSimpleProductSkuInSearchTextBox
		$I->seeInTitle("Search results for: 'test_simple_product_sku" . msq("simpleProductRegularPrice325InStock") . "'"); // stepKey: assertQuickSearchTitleFillSimpleProductSkuInSearchTextBox
		$I->see("Search results for: 'test_simple_product_sku" . msq("simpleProductRegularPrice325InStock") . "'", ".page-title span"); // stepKey: assertQuickSearchNameFillSimpleProductSkuInSearchTextBox
		$I->comment("Exiting Action Group [fillSimpleProductSkuInSearchTextBox] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [seeProductName] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadSeeProductName
		$I->see("TestSimpleProduct" . msq("simpleProductRegularPrice325InStock"), ".product-item-name"); // stepKey: seeProductNameSeeProductName
		$I->comment("Exiting Action Group [seeProductName] StorefrontAssertProductNameOnProductMainPageActionGroup");
	}
}
