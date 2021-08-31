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
 * @Title("MC-10803: Update Simple Product with Regular Price (In Stock) Not Visible Individually")
 * @Description("Test log in to Update Simple Product and Update Simple Product with Regular Price (In Stock) Not Visible Individually<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminUpdateSimpleProductWithRegularPriceInStockNotVisibleIndividuallyTest.xml<br>")
 * @TestCaseId("MC-10803")
 * @group catalog
 * @group mtf_migrated
 */
class AdminUpdateSimpleProductWithRegularPriceInStockNotVisibleIndividuallyTestCest
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
		$I->fillField("input.admin__control-text[name='sku']", "test_simple_product_sku" . msq("simpleProductNotVisibleIndividually")); // stepKey: fillProductSkuFilterDeleteCreatedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteCreatedProductWaitForPageLoad
		$I->see("test_simple_product_sku" . msq("simpleProductNotVisibleIndividually"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteCreatedProduct
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
	public function AdminUpdateSimpleProductWithRegularPriceInStockNotVisibleIndividuallyTest(AcceptanceTester $I)
	{
		$I->comment("Search default simple product in the grid page");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickFirstRowToOpenDefaultSimpleProduct] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageClickFirstRowToOpenDefaultSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadClickFirstRowToOpenDefaultSimpleProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersClickFirstRowToOpenDefaultSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersClickFirstRowToOpenDefaultSimpleProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersClickFirstRowToOpenDefaultSimpleProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('initialSimpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterClickFirstRowToOpenDefaultSimpleProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersClickFirstRowToOpenDefaultSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersClickFirstRowToOpenDefaultSimpleProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadClickFirstRowToOpenDefaultSimpleProduct
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('initialSimpleProduct', 'sku', 'test') . "']]"); // stepKey: openSelectedProductClickFirstRowToOpenDefaultSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadClickFirstRowToOpenDefaultSimpleProduct
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleClickFirstRowToOpenDefaultSimpleProduct
		$I->comment("Exiting Action Group [clickFirstRowToOpenDefaultSimpleProduct] FilterAndSelectProductActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Update simple product with regular price(in stock)");
		$I->comment("Entering Action Group [fillSimpleProductName] FillMainProductFormByStringActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "TestSimpleProduct" . msq("simpleProductNotVisibleIndividually")); // stepKey: fillProductNameFillSimpleProductName
		$I->fillField(".admin__field[data-index=sku] input", "test_simple_product_sku" . msq("simpleProductNotVisibleIndividually")); // stepKey: fillProductSkuFillSimpleProductName
		$I->fillField(".admin__field[data-index=price] input", "325.00"); // stepKey: fillProductPriceFillSimpleProductName
		$I->fillField(".admin__field[data-index=qty] input", "123"); // stepKey: fillProductQtyFillSimpleProductName
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: selectStockStatusFillSimpleProductName
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillSimpleProductNameWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightFillSimpleProductName
		$I->fillField(".admin__field[data-index=weight] input", "129.0000"); // stepKey: fillProductWeightFillSimpleProductName
		$I->comment("Exiting Action Group [fillSimpleProductName] FillMainProductFormByStringActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [fillSearchForInitialCategory] SetCategoryByNameActionGroup");
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('initialCategoryEntity', 'name', 'test')]); // stepKey: searchAndSelectCategoryFillSearchForInitialCategory
		$I->waitForPageLoad(30); // stepKey: searchAndSelectCategoryFillSearchForInitialCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [fillSearchForInitialCategory] SetCategoryByNameActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [unselectInitialCategory] AdminSubmitCategoriesPopupActionGroup");
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickOnDoneButtonUnselectInitialCategory
		$I->waitForPageLoad(30); // stepKey: clickOnDoneButtonUnselectInitialCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryApplyUnselectInitialCategory
		$I->comment("Exiting Action Group [unselectInitialCategory] AdminSubmitCategoriesPopupActionGroup");
		$I->comment("Entering Action Group [fillSearchCategory] SetCategoryByNameActionGroup");
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('categoryEntity', 'name', 'test')]); // stepKey: searchAndSelectCategoryFillSearchCategory
		$I->waitForPageLoad(30); // stepKey: searchAndSelectCategoryFillSearchCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [fillSearchCategory] SetCategoryByNameActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickOnDoneAdvancedCategorySelect] AdminSubmitCategoriesPopupActionGroup");
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickOnDoneButtonClickOnDoneAdvancedCategorySelect
		$I->waitForPageLoad(30); // stepKey: clickOnDoneButtonClickOnDoneAdvancedCategorySelectWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryApplyClickOnDoneAdvancedCategorySelect
		$I->comment("Exiting Action Group [clickOnDoneAdvancedCategorySelect] AdminSubmitCategoriesPopupActionGroup");
		$I->selectOption("//select[@name='product[visibility]']", "Not Visible Individually"); // stepKey: selectVisibility
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [fillSimpleProductUrlKey] SetProductUrlKeyByStringActionGroup");
		$I->conditionalClick("div[data-index='search-engine-optimization']", "input[name='product[url_key]']", false); // stepKey: openSeoSectionFillSimpleProductUrlKey
		$I->fillField("input[name='product[url_key]']", "test-simple-product" . msq("simpleProductNotVisibleIndividually")); // stepKey: fillUrlKeyFillSimpleProductUrlKey
		$I->comment("Exiting Action Group [fillSimpleProductUrlKey] SetProductUrlKeyByStringActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfAdminProductFormSection
		$I->comment("Entering Action Group [clickSaveButton] AdminProductFormSaveButtonClickActionGroup");
		$I->click("#save-button"); // stepKey: clickSaveButtonClickSaveButton
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavedClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminProductFormSaveButtonClickActionGroup");
		$I->comment("Verify customer see success message");
		$I->comment("Entering Action Group [seeAssertSimpleProductSaveSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleSeeAssertSimpleProductSaveSuccessMessage
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: verifyMessageSeeAssertSimpleProductSaveSuccessMessage
		$I->comment("Exiting Action Group [seeAssertSimpleProductSaveSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Search updated simple product(from above step) in the grid page");
		$I->comment("Entering Action Group [openProductCatalogPageToSearchUpdatedSimpleProduct] AdminProductCatalogPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openProductCatalogPageOpenProductCatalogPageToSearchUpdatedSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadOpenProductCatalogPageToSearchUpdatedSimpleProduct
		$I->comment("Exiting Action Group [openProductCatalogPageToSearchUpdatedSimpleProduct] AdminProductCatalogPageOpenActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickApplyFiltersButton] FilterProductGridBySkuAndNameActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialClickApplyFiltersButton
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialClickApplyFiltersButtonWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersClickApplyFiltersButton
		$I->fillField("input.admin__control-text[name='sku']", "test_simple_product_sku" . msq("simpleProductNotVisibleIndividually")); // stepKey: fillProductSkuFilterClickApplyFiltersButton
		$I->fillField("input.admin__control-text[name='name']", "TestSimpleProduct" . msq("simpleProductNotVisibleIndividually")); // stepKey: fillProductNameFilterClickApplyFiltersButton
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersClickApplyFiltersButton
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersClickApplyFiltersButtonWaitForPageLoad
		$I->comment("Exiting Action Group [clickApplyFiltersButton] FilterProductGridBySkuAndNameActionGroup");
		$I->click(".data-row:nth-of-type(1)"); // stepKey: clickFirstRowToVerifyUpdatedSimpleProductVisibleInGrid
		$I->waitForPageLoad(30); // stepKey: clickFirstRowToVerifyUpdatedSimpleProductVisibleInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitUntilSimpleProductPageIsOpened
		$I->comment("Verify customer see updated simple product in the product form page");
		$I->comment("Entering Action Group [seeSimpleProductName] AdminAssertProductInfoOnEditPageActionGroup");
		$I->waitForElementVisible("input[name='product[status]']", 30); // stepKey: waitForProductStatusSeeSimpleProductName
		$I->seeElement("input[name='product[status]'][value='1']"); // stepKey: seeProductStatusSeeSimpleProductName
		$I->waitForPageLoad(30); // stepKey: seeProductStatusSeeSimpleProductNameWaitForPageLoad
		$I->seeOptionIsSelected("div[data-index='attribute_set_id'] .admin__field-control", "Default"); // stepKey: seeProductAttributeSetSeeSimpleProductName
		$I->seeInField(".admin__field[data-index=name] input", "TestSimpleProduct" . msq("simpleProductNotVisibleIndividually")); // stepKey: seeProductNameSeeSimpleProductName
		$I->seeInField(".admin__field[data-index=sku] input", "test_simple_product_sku" . msq("simpleProductNotVisibleIndividually")); // stepKey: seeProductSkuSeeSimpleProductName
		$I->seeInField(".admin__field[data-index=price] input", "325.00"); // stepKey: seeProductPriceSeeSimpleProductName
		$I->seeInField(".admin__field[data-index=qty] input", "123"); // stepKey: seeProductQuantitySeeSimpleProductName
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeProductStockStatusSeeSimpleProductName
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusSeeSimpleProductNameWaitForPageLoad
		$I->seeInField(".admin__field[data-index=weight] input", "129"); // stepKey: seeProductWeightSeeSimpleProductName
		$I->seeOptionIsSelected("//select[@name='product[visibility]']", "Not Visible Individually"); // stepKey: seeProductVisibilitySeeSimpleProductName
		$I->seeElement("//*[@class='admin__action-multiselect-crumb']/span[contains(text(), '" . $I->retrieveEntityField('categoryEntity', 'name', 'test') . "')]"); // stepKey: seeProductCategoriesSeeSimpleProductName
		$I->comment("Exiting Action Group [seeSimpleProductName] AdminAssertProductInfoOnEditPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->scrollTo("div[data-index='search-engine-optimization']", 0, -80); // stepKey: scrollToAdminProductSEOSection
		$I->waitForPageLoad(30); // stepKey: scrollToAdminProductSEOSectionWaitForPageLoad
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: clickAdminProductSEOSectionHeader
		$I->waitForPageLoad(30); // stepKey: clickAdminProductSEOSectionHeaderWaitForPageLoad
		$I->seeInField("input[name='product[url_key]']", "test-simple-product" . msq("simpleProductNotVisibleIndividually")); // stepKey: seeSimpleProductUrlKey
		$I->comment("Verify customer don't see updated simple product link on magento storefront page");
		$I->comment("Entering Action Group [goToMagentoStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToMagentoStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToMagentoStorefrontPage
		$I->comment("Exiting Action Group [goToMagentoStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [fillSimpleProductSkuInSearchTextBox] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "test_simple_product_sku" . msq("simpleProductNotVisibleIndividually")); // stepKey: fillInputFillSimpleProductSkuInSearchTextBox
		$I->submitForm("#search", []); // stepKey: submitQuickSearchFillSimpleProductSkuInSearchTextBox
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlFillSimpleProductSkuInSearchTextBox
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyFillSimpleProductSkuInSearchTextBox
		$I->seeInTitle("Search results for: 'test_simple_product_sku" . msq("simpleProductNotVisibleIndividually") . "'"); // stepKey: assertQuickSearchTitleFillSimpleProductSkuInSearchTextBox
		$I->see("Search results for: 'test_simple_product_sku" . msq("simpleProductNotVisibleIndividually") . "'", ".page-title span"); // stepKey: assertQuickSearchNameFillSimpleProductSkuInSearchTextBox
		$I->comment("Exiting Action Group [fillSimpleProductSkuInSearchTextBox] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [dontSeeSimpleProductNameOnMagentoStorefrontPage] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadDontSeeSimpleProductNameOnMagentoStorefrontPage
		$I->dontSee("TestSimpleProduct" . msq("simpleProductNotVisibleIndividually"), ".product-item-name"); // stepKey: dontSeeProductNameDontSeeSimpleProductNameOnMagentoStorefrontPage
		$I->comment("Exiting Action Group [dontSeeSimpleProductNameOnMagentoStorefrontPage] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
	}
}
