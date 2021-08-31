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
 * @Title("MC-6504: Update Virtual Product with Tier Price (In Stock) Visible in Category and Search")
 * @Description("Test log in to Update Virtual Product and Update Virtual Product with Tier Price (In Stock) Visible in Category and Search<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminUpdateVirtualProductWithTierPriceInStockVisibleInCategoryAndSearchTest.xml<br>")
 * @TestCaseId("MC-6504")
 * @group catalog
 * @group mtf_migrated
 */
class AdminUpdateVirtualProductWithTierPriceInStockVisibleInCategoryAndSearchTestCest
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
		$I->createEntity("initialCategoryEntity", "hook", "SimpleSubCategory", [], []); // stepKey: initialCategoryEntity
		$I->createEntity("initialVirtualProduct", "hook", "defaultVirtualProduct", ["initialCategoryEntity"], []); // stepKey: initialVirtualProduct
		$I->createEntity("categoryEntity", "hook", "SimpleSubCategory", [], []); // stepKey: categoryEntity
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$RunToScheduleJobs = $I->magentoCron("index", 90); // stepKey: RunToScheduleJobs
		$I->comment($RunToScheduleJobs);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("initialCategoryEntity", "hook"); // stepKey: deleteInitialCategory
		$I->deleteEntity("categoryEntity", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [deleteVirtualProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteVirtualProduct
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteVirtualProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteVirtualProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteVirtualProduct
		$I->fillField("input.admin__control-text[name='sku']", "virtual_sku" . msq("updateVirtualProductTierPriceInStock")); // stepKey: fillProductSkuFilterDeleteVirtualProduct
		$I->fillField("input.admin__control-text[name='name']", "VirtualProduct" . msq("updateVirtualProductTierPriceInStock")); // stepKey: fillProductNameFilterDeleteVirtualProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteVirtualProductWaitForPageLoad
		$I->see("virtual_sku" . msq("updateVirtualProductTierPriceInStock"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteVirtualProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteVirtualProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteVirtualProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteVirtualProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteVirtualProductWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteVirtualProduct
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteVirtualProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteVirtualProductWaitForPageLoad
		$I->comment("Exiting Action Group [deleteVirtualProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("Entering Action Group [clearProductsGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearProductsGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearProductsGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductsGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"Update Virtual Product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateVirtualProductWithTierPriceInStockVisibleInCategoryAndSearchTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openProductEditPageBySKU] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageOpenProductEditPageBySKU
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadOpenProductEditPageBySKU
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersOpenProductEditPageBySKU
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersOpenProductEditPageBySKUWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersOpenProductEditPageBySKU
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('initialVirtualProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterOpenProductEditPageBySKU
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersOpenProductEditPageBySKU
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersOpenProductEditPageBySKUWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadOpenProductEditPageBySKU
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('initialVirtualProduct', 'sku', 'test') . "']]"); // stepKey: openSelectedProductOpenProductEditPageBySKU
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadOpenProductEditPageBySKU
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleOpenProductEditPageBySKU
		$I->comment("Exiting Action Group [openProductEditPageBySKU] FilterAndSelectProductActionGroup");
		$I->comment("Update virtual product with tier price");
		$I->comment("Entering Action Group [fillNewProductData] FillMainProductFormNoWeightActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "VirtualProduct" . msq("updateVirtualProductTierPriceInStock")); // stepKey: fillProductNameFillNewProductData
		$I->fillField(".admin__field[data-index=sku] input", "virtual_sku" . msq("updateVirtualProductTierPriceInStock")); // stepKey: fillProductSkuFillNewProductData
		$I->fillField(".admin__field[data-index=price] input", "145.00"); // stepKey: fillProductPriceFillNewProductData
		$I->fillField(".admin__field[data-index=qty] input", "999"); // stepKey: fillProductQtyFillNewProductData
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: selectStockStatusFillNewProductData
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillNewProductDataWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has no weight"); // stepKey: selectWeightFillNewProductData
		$I->comment("Exiting Action Group [fillNewProductData] FillMainProductFormNoWeightActionGroup");
		$I->comment("Press enter to validate advanced pricing link");
		$I->pressKey(".admin__field[data-index=price] input", \Facebook\WebDriver\WebDriverKeys::ENTER); // stepKey: pressEnterKey
		$I->comment("Entering Action Group [openAdvancedPricingDialog] AdminProductFormOpenAdvancedPricingDialogActionGroup");
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickAdvancedPricingLinkOpenAdvancedPricingDialog
		$I->waitForPageLoad(30); // stepKey: clickAdvancedPricingLinkOpenAdvancedPricingDialogWaitForPageLoad
		$I->waitForElementVisible("aside.product_form_product_form_advanced_pricing_modal h1.modal-title", 30); // stepKey: waitForModalTitleAppearsOpenAdvancedPricingDialog
		$I->see("Advanced Pricing", "aside.product_form_product_form_advanced_pricing_modal h1.modal-title"); // stepKey: checkModalTitleOpenAdvancedPricingDialog
		$I->comment("Exiting Action Group [openAdvancedPricingDialog] AdminProductFormOpenAdvancedPricingDialogActionGroup");
		$I->comment("Entering Action Group [addTierPrice] AdminProductFormAdvancedPricingAddTierPriceActionGroup");
		$I->waitForElementVisible("[data-action='add_new_row']", 30); // stepKey: waitForGroupPriceAddButtonAppearsAddTierPrice
		$I->waitForPageLoad(30); // stepKey: waitForGroupPriceAddButtonAppearsAddTierPriceWaitForPageLoad
		$I->click("[data-action='add_new_row']"); // stepKey: clickCustomerGroupPriceAddButtonAddTierPrice
		$I->waitForPageLoad(30); // stepKey: clickCustomerGroupPriceAddButtonAddTierPriceWaitForPageLoad
		$I->waitForElementVisible("[data-index='tier_price'] table tbody tr.data-row:last-child [name*='[website_id]']", 30); // stepKey: waitForPriceWebsiteInputAppearsAddTierPrice
		$I->selectOption("[data-index='tier_price'] table tbody tr.data-row:last-child [name*='[website_id]']", "All Websites [USD]"); // stepKey: selectWebsiteAddTierPrice
		$I->selectOption("[data-index='tier_price'] table tbody tr.data-row:last-child [name*='[cust_group]']", "ALL GROUPS"); // stepKey: selectCustomerGroupAddTierPrice
		$I->fillField("[data-index='tier_price'] table tbody tr.data-row:last-child [name*='[price_qty]']", "2"); // stepKey: fillQuantityAddTierPrice
		$I->selectOption("[data-index='tier_price'] table tbody tr.data-row:last-child [name*='[value_type]']", "Fixed"); // stepKey: selectPriceTypeAddTierPrice
		$priceAmountSelectorAddTierPrice = $I->executeJS("return 'Fixed' == 'Discount' ? \"[data-index='tier_price'] table tbody tr.data-row:last-child [name*='[percentage_value]']\" : \"[data-index='tier_price'] table tbody tr.data-row:last-child [name*='[price]']\""); // stepKey: priceAmountSelectorAddTierPrice
		$I->waitForElementVisible($priceAmountSelectorAddTierPrice, 30); // stepKey: waitPriceAmountFieldAppersAddTierPrice
		$I->fillField($priceAmountSelectorAddTierPrice, "90.00"); // stepKey: fillPriceAmountAddTierPrice
		$I->comment("Exiting Action Group [addTierPrice] AdminProductFormAdvancedPricingAddTierPriceActionGroup");
		$I->comment("Entering Action Group [doneAdvancedPricingModal] AdminProductFormDoneAdvancedPricingDialogActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageDoneAdvancedPricingModal
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButtonDoneAdvancedPricingModal
		$I->waitForPageLoad(30); // stepKey: clickDoneButtonDoneAdvancedPricingModalWaitForPageLoad
		$I->comment("Exiting Action Group [doneAdvancedPricingModal] AdminProductFormDoneAdvancedPricingDialogActionGroup");
		$I->selectOption("//*[@name='product[tax_class_id]']", "Taxable Goods"); // stepKey: selectProductStockClass
		$I->comment("Entering Action Group [unselectInitialCategory] RemoveCategoryFromProductActionGroup");
		$I->click("div[data-index='category_ids']"); // stepKey: clickCategoriesDropDownUnselectInitialCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoriesDropDownUnselectInitialCategoryWaitForPageLoad
		$I->click("//span[@class='admin__action-multiselect-crumb']/span[contains(.,'" . $I->retrieveEntityField('initialCategoryEntity', 'name', 'test') . "')]/../button[@data-action='remove-selected-item']"); // stepKey: unselectCategoriesUnselectInitialCategory
		$I->waitForPageLoad(30); // stepKey: unselectCategoriesUnselectInitialCategoryWaitForPageLoad
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickOnDoneAdvancedCategoryUnselectInitialCategory
		$I->waitForPageLoad(30); // stepKey: clickOnDoneAdvancedCategoryUnselectInitialCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [unselectInitialCategory] RemoveCategoryFromProductActionGroup");
		$I->comment("Entering Action Group [setNewCategory] SetCategoryByNameActionGroup");
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('categoryEntity', 'name', 'test')]); // stepKey: searchAndSelectCategorySetNewCategory
		$I->waitForPageLoad(30); // stepKey: searchAndSelectCategorySetNewCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [setNewCategory] SetCategoryByNameActionGroup");
		$I->selectOption("//select[@name='product[visibility]']", "Catalog, Search"); // stepKey: selectVisibility
		$I->comment("Entering Action Group [updateUrlKey] SetProductUrlKeyByStringActionGroup");
		$I->conditionalClick("div[data-index='search-engine-optimization']", "input[name='product[url_key]']", false); // stepKey: openSeoSectionUpdateUrlKey
		$I->fillField("input[name='product[url_key]']", "virtual-product" . msq("updateVirtualProductTierPriceInStock")); // stepKey: fillUrlKeyUpdateUrlKey
		$I->comment("Exiting Action Group [updateUrlKey] SetProductUrlKeyByStringActionGroup");
		$I->comment("Entering Action Group [saveProductAndCheckSuccessMessage] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductAndCheckSuccessMessage
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductAndCheckSuccessMessage
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductAndCheckSuccessMessageWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductAndCheckSuccessMessage
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductAndCheckSuccessMessageWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductAndCheckSuccessMessage
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductAndCheckSuccessMessage
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductAndCheckSuccessMessage
		$I->comment("Exiting Action Group [saveProductAndCheckSuccessMessage] SaveProductFormActionGroup");
		$I->comment("Search updated virtual product(from above step) in the grid");
		$I->comment("Entering Action Group [searchForSimpleProduct] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForSimpleProduct
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForSimpleProduct
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForSimpleProduct
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForSimpleProduct
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForSimpleProductWaitForPageLoad
		$I->fillField("input[name=sku]", "virtual_sku" . msq("updateVirtualProductTierPriceInStock")); // stepKey: fillSkuFieldOnFiltersSectionSearchForSimpleProduct
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForSimpleProductWaitForPageLoad
		$I->comment("Exiting Action Group [searchForSimpleProduct] SearchForProductOnBackendActionGroup");
		$I->comment("Verify customer see updated virtual product with tier price(from the above step) in the product form page");
		$I->comment("Entering Action Group [verifyProductInAdminEditForm] AssertProductInfoOnEditPageActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='virtual_sku" . msq("updateVirtualProductTierPriceInStock") . "']]"); // stepKey: clickOnProductRowVerifyProductInAdminEditForm
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadVerifyProductInAdminEditForm
		$I->seeInField(".admin__field[data-index=sku] input", "virtual_sku" . msq("updateVirtualProductTierPriceInStock")); // stepKey: seeProductSkuOnEditProductPageVerifyProductInAdminEditForm
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadVerifyProductInAdminEditForm
		$I->seeInField(".admin__field[data-index=name] input", "VirtualProduct" . msq("updateVirtualProductTierPriceInStock")); // stepKey: seeProductNameVerifyProductInAdminEditForm
		$I->seeInField(".admin__field[data-index=sku] input", "virtual_sku" . msq("updateVirtualProductTierPriceInStock")); // stepKey: seeProductSkuVerifyProductInAdminEditForm
		$I->seeInField(".admin__field[data-index=price] input", "145.00"); // stepKey: seeProductPriceVerifyProductInAdminEditForm
		$I->seeInField(".admin__field[data-index=qty] input", "999"); // stepKey: seeProductQuantityVerifyProductInAdminEditForm
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeProductStockStatusVerifyProductInAdminEditForm
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusVerifyProductInAdminEditFormWaitForPageLoad
		$I->comment("Exiting Action Group [verifyProductInAdminEditForm] AssertProductInfoOnEditPageActionGroup");
		$I->comment("Entering Action Group [openAdvancedPricingDialogAgain] AdminProductFormOpenAdvancedPricingDialogActionGroup");
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickAdvancedPricingLinkOpenAdvancedPricingDialogAgain
		$I->waitForPageLoad(30); // stepKey: clickAdvancedPricingLinkOpenAdvancedPricingDialogAgainWaitForPageLoad
		$I->waitForElementVisible("aside.product_form_product_form_advanced_pricing_modal h1.modal-title", 30); // stepKey: waitForModalTitleAppearsOpenAdvancedPricingDialogAgain
		$I->see("Advanced Pricing", "aside.product_form_product_form_advanced_pricing_modal h1.modal-title"); // stepKey: checkModalTitleOpenAdvancedPricingDialogAgain
		$I->comment("Exiting Action Group [openAdvancedPricingDialogAgain] AdminProductFormOpenAdvancedPricingDialogActionGroup");
		$I->comment("Entering Action Group [checkTierPrice] AssertAdminProductFormAdvancedPricingCheckTierPriceActionGroup");
		$I->waitForElementVisible("[name='product[tier_price][0][website_id]']", 30); // stepKey: waitForPricesGridAppearsCheckTierPrice
		$I->seeInField("[name='product[tier_price][0][website_id]']", "All Websites [USD]"); // stepKey: seeWebsiteCheckTierPrice
		$I->seeInField("[name='product[tier_price][0][cust_group]']", "ALL GROUPS"); // stepKey: seeCustomerGroupCheckTierPrice
		$I->seeInField("[name='product[tier_price][0][price_qty]']", "2"); // stepKey: seeQuantityCheckTierPrice
		$I->seeInField("[name='product[tier_price][0][value_type]']", "Fixed"); // stepKey: seePriceTypeCheckTierPrice
		$priceAmountSelectorCheckTierPrice = $I->executeJS("return 'Fixed' == 'Discount' ? \"[name='product[tier_price][0][percentage_value]']\" : \"[name='product[tier_price][0][price]']\""); // stepKey: priceAmountSelectorCheckTierPrice
		$I->seeInField($priceAmountSelectorCheckTierPrice, "90.00"); // stepKey: seePriceAmountCheckTierPrice
		$I->comment("Exiting Action Group [checkTierPrice] AssertAdminProductFormAdvancedPricingCheckTierPriceActionGroup");
		$I->comment("Entering Action Group [closeAdvancedPricingModal] AdminProductFormCloseAdvancedPricingDialogActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageCloseAdvancedPricingModal
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-close"); // stepKey: clickCloseButtonCloseAdvancedPricingModal
		$I->waitForPageLoad(30); // stepKey: clickCloseButtonCloseAdvancedPricingModalWaitForPageLoad
		$I->comment("Exiting Action Group [closeAdvancedPricingModal] AdminProductFormCloseAdvancedPricingDialogActionGroup");
		$I->seeInField("//*[@name='product[tax_class_id]']", "Taxable Goods"); // stepKey: seeProductTaxClass
		$I->click("div[data-index='category_ids']"); // stepKey: clickCategoriesDropDownToVerify
		$I->waitForPageLoad(30); // stepKey: clickCategoriesDropDownToVerifyWaitForPageLoad
		$selectedCategories = $I->grabMultiple("//*[@data-index='container_category_ids']//*[contains(@class, '_selected')]"); // stepKey: selectedCategories
		$I->assertEquals([$I->retrieveEntityField('categoryEntity', 'name', 'test')], $selectedCategories); // stepKey: assertSelectedCategories
		$I->comment("Entering Action Group [clickOnDoneOnCategorySelect] AdminSubmitCategoriesPopupActionGroup");
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickOnDoneButtonClickOnDoneOnCategorySelect
		$I->waitForPageLoad(30); // stepKey: clickOnDoneButtonClickOnDoneOnCategorySelectWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryApplyClickOnDoneOnCategorySelect
		$I->comment("Exiting Action Group [clickOnDoneOnCategorySelect] AdminSubmitCategoriesPopupActionGroup");
		$I->seeInField("//select[@name='product[visibility]']", "Catalog, Search"); // stepKey: seeVisibility
		$I->conditionalClick("div[data-index='search-engine-optimization']", "input[name='use_default[url_key]']", false); // stepKey: openSearchEngineOptimizationSection
		$I->scrollTo("div[data-index='search-engine-optimization']"); // stepKey: scrollToAdminProductSEOSection
		$I->waitForPageLoad(30); // stepKey: scrollToAdminProductSEOSectionWaitForPageLoad
		$I->seeInField("input[name='product[url_key]']", "virtual-product" . msq("updateVirtualProductTierPriceInStock")); // stepKey: seeUrlKey
		$I->comment("Verify customer see updated virtual product link on category page");
		$I->comment("Entering Action Group [openCategoryPageOnFrontend] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryEntity', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageOpenCategoryPageOnFrontend
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadOpenCategoryPageOnFrontend
		$I->comment("Exiting Action Group [openCategoryPageOnFrontend] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Entering Action Group [checkProductOnCategoryPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), 'VirtualProduct" . msq("updateVirtualProductTierPriceInStock") . "')]", 30); // stepKey: assertProductNameCheckProductOnCategoryPage
		$I->comment("Exiting Action Group [checkProductOnCategoryPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Verify customer see updated virtual product with tier price on product storefront page");
		$I->comment("Entering Action Group [verifyProductOnFrontend] AssertProductInStorefrontProductPageActionGroup");
		$I->comment("Go to storefront product page, assert product name, sku and price");
		$I->amOnPage("virtual-product" . msq("updateVirtualProductTierPriceInStock") . ".html"); // stepKey: navigateToProductPageVerifyProductOnFrontend
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2VerifyProductOnFrontend
		$I->seeInTitle("VirtualProduct" . msq("updateVirtualProductTierPriceInStock")); // stepKey: assertProductNameTitleVerifyProductOnFrontend
		$I->see("VirtualProduct" . msq("updateVirtualProductTierPriceInStock"), ".base"); // stepKey: assertProductNameVerifyProductOnFrontend
		$I->see("145.00", "div.price-box.price-final_price"); // stepKey: assertProductPriceVerifyProductOnFrontend
		$I->see("virtual_sku" . msq("updateVirtualProductTierPriceInStock"), ".product.attribute.sku>.value"); // stepKey: assertProductSkuVerifyProductOnFrontend
		$I->comment("Exiting Action Group [verifyProductOnFrontend] AssertProductInStorefrontProductPageActionGroup");
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertStockAvailableOnProductPage
		$I->see("Buy 2 for $90.00 each and save 38%", ".prices-tier li[class='item']"); // stepKey: assertTierPriceTextOnProductPage
		$I->comment("Verify customer see updated virtual product link on magento storefront page and is searchable by sku");
		$I->comment("Entering Action Group [quickSearchProductBySku] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "virtual_sku" . msq("updateVirtualProductTierPriceInStock")); // stepKey: fillInputQuickSearchProductBySku
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchProductBySku
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchProductBySku
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchProductBySku
		$I->seeInTitle("Search results for: 'virtual_sku" . msq("updateVirtualProductTierPriceInStock") . "'"); // stepKey: assertQuickSearchTitleQuickSearchProductBySku
		$I->see("Search results for: 'virtual_sku" . msq("updateVirtualProductTierPriceInStock") . "'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchProductBySku
		$I->comment("Exiting Action Group [quickSearchProductBySku] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [checkProductInSearchResults] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->see("VirtualProduct" . msq("updateVirtualProductTierPriceInStock"), "//div[contains(@class, 'product-item-info') and .//*[contains(., 'VirtualProduct" . msq("updateVirtualProductTierPriceInStock") . "')]]"); // stepKey: seeProductNameCheckProductInSearchResults
		$I->comment("Exiting Action Group [checkProductInSearchResults] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->see("As low as $90.00", ".minimal-price-link > span"); // stepKey: assertTierPriceTextOnCategoryPage
	}
}
