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
 * @Title("MC-37515: Customer should be able to see all the bundle items in invoice view")
 * @Description("Customer should be able to see all the bundle items in invoice view<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/StorefrontBundlePlaceOrderWithMultipleOptionsSuccessTest.xml<br>")
 * @TestCaseId("MC-37515")
 * @group Bundle
 */
class StorefrontBundlePlaceOrderWithMultipleOptionsSuccessTestCest
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
		$I->createEntity("createPreReqCategory", "hook", "_defaultCategory", [], []); // stepKey: createPreReqCategory
		$I->createEntity("firstSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: firstSimpleProduct
		$I->createEntity("secondSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: secondSimpleProduct
		$I->createEntity("createCustomer", "hook", "CustomerEntityOne", [], []); // stepKey: createCustomer
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
		$I->deleteEntity("createPreReqCategory", "hook"); // stepKey: deletePreReqCategory
		$I->deleteEntity("firstSimpleProduct", "hook"); // stepKey: deleteFirstSimpleProduct
		$I->deleteEntity("secondSimpleProduct", "hook"); // stepKey: deleteSecondSimpleProduct
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
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
	 * @Features({"Bundle"})
	 * @Stories({"Bundle product details page"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontBundlePlaceOrderWithMultipleOptionsSuccessTest(AcceptanceTester $I)
	{
		$I->comment("Create new bundle product");
		$I->comment("Entering Action Group [createBundleProduct] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("actionGroup:GoToSpecifiedCreateProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexCreateBundleProduct
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownCreateBundleProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownCreateBundleProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-bundle']"); // stepKey: clickAddProductCreateBundleProduct
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadCreateBundleProduct
		$I->comment("Exiting Action Group [createBundleProduct] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("Fill all main fields");
		$I->comment("Entering Action Group [fillMainProductFields] FillMainBundleProductFormActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "BundleProduct" . msq("BundleProduct")); // stepKey: fillProductSkuFillMainProductFields
		$I->fillField(".admin__field[data-index=sku] input", "bundleproduct" . msq("BundleProduct")); // stepKey: fillProductNameFillMainProductFields
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillMainProductFields
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillMainProductFieldsWaitForPageLoad
		$I->comment("Exiting Action Group [fillMainProductFields] FillMainBundleProductFormActionGroup");
		$I->comment("Add first bundle option to the product");
		$I->comment("Entering Action Group [addFirstBundleOption] AddBundleOptionWithTwoProductsActionGroup");
		$I->conditionalClick("//span[text()='Bundle Items']", "//span[text()='Bundle Items']", false); // stepKey: conditionallyOpenSectionBundleItemsAddFirstBundleOption
		$I->scrollTo("//span[text()='Bundle Items']"); // stepKey: scrollUpABitAddFirstBundleOption
		$I->click("button[data-index='add_button']"); // stepKey: clickAddOptionAddFirstBundleOption
		$I->waitForElementVisible("[name='bundle_options[bundle_options][0][title]']", 30); // stepKey: waitForOptionsAddFirstBundleOption
		$I->fillField("[name='bundle_options[bundle_options][0][title]']", "bundle-option-checkbox" . msq("CheckboxOption")); // stepKey: fillTitleAddFirstBundleOption
		$I->selectOption("[name='bundle_options[bundle_options][0][type]']", "checkbox"); // stepKey: selectTypeAddFirstBundleOption
		$I->waitForElementVisible("//tr[1]//button[@data-index='modal_set']", 30); // stepKey: waitForAddBtnAddFirstBundleOption
		$I->waitForPageLoad(30); // stepKey: waitForAddBtnAddFirstBundleOptionWaitForPageLoad
		$I->click("//tr[1]//button[@data-index='modal_set']"); // stepKey: clickAddAddFirstBundleOption
		$I->waitForPageLoad(30); // stepKey: clickAddAddFirstBundleOptionWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters1AddFirstBundleOption
		$I->waitForPageLoad(30); // stepKey: clickClearFilters1AddFirstBundleOptionWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters1AddFirstBundleOption
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('firstSimpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilter1AddFirstBundleOption
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters1AddFirstBundleOption
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters1AddFirstBundleOptionWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad1AddFirstBundleOption
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct1AddFirstBundleOption
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters2AddFirstBundleOption
		$I->waitForPageLoad(30); // stepKey: clickClearFilters2AddFirstBundleOptionWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters2AddFirstBundleOption
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('secondSimpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilter2AddFirstBundleOption
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters2AddFirstBundleOption
		$I->waitForPageLoad(30); // stepKey: clickApplyFilters2AddFirstBundleOptionWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoad2AddFirstBundleOption
		$I->checkOption("//tr[1]//input[@data-action='select-row']"); // stepKey: selectProduct2AddFirstBundleOption
		$I->click(".product_form_product_form_bundle-items_modal button.action-primary"); // stepKey: clickAddButton1AddFirstBundleOption
		$I->waitForPageLoad(30); // stepKey: clickAddButton1AddFirstBundleOptionWaitForPageLoad
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][0][selection_qty]']", "50"); // stepKey: fillQuantity1AddFirstBundleOption
		$I->fillField("[name='bundle_options[bundle_options][0][bundle_selections][1][selection_qty]']", "50"); // stepKey: fillQuantity2AddFirstBundleOption
		$I->comment("Exiting Action Group [addFirstBundleOption] AddBundleOptionWithTwoProductsActionGroup");
		$I->comment("Save product form");
		$I->comment("Entering Action Group [saveWithThreeOptions] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveWithThreeOptions
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveWithThreeOptions
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveWithThreeOptionsWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveWithThreeOptions
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveWithThreeOptionsWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveWithThreeOptions
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveWithThreeOptions
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveWithThreeOptions
		$I->comment("Exiting Action Group [saveWithThreeOptions] SaveProductFormActionGroup");
		$I->comment("Login customer on storefront");
		$I->comment("Entering Action Group [loginCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginCustomer
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginCustomer
		$I->comment("Exiting Action Group [loginCustomer] LoginToStorefrontActionGroup");
		$I->comment("Open Product Page");
		$I->comment("Entering Action Group [openStorefrontProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/bundleproduct" . msq("BundleProduct") . ".html"); // stepKey: openProductPageOpenStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenStorefrontProductPage
		$I->comment("Exiting Action Group [openStorefrontProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Add bundle to cart");
		$I->comment("Entering Action Group [clickAddToCart] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->waitForElementVisible("#bundle-slide", 30); // stepKey: waitForCustomizeAndAddToCartButtonClickAddToCart
		$I->waitForPageLoad(30); // stepKey: waitForCustomizeAndAddToCartButtonClickAddToCartWaitForPageLoad
		$I->click("#bundle-slide"); // stepKey: clickOnCustomizeAndAddToCartButtonClickAddToCart
		$I->waitForPageLoad(30); // stepKey: clickOnCustomizeAndAddToCartButtonClickAddToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickAddToCart
		$I->comment("Exiting Action Group [clickAddToCart] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->checkOption("//label//span[contains(text(), 'bundle-option-checkbox" . msq("CheckboxOption") . "')]/../..//div[@class='control']//div[@class='field choice'][1]/input"); // stepKey: selectOption2Product1
		$I->checkOption("//label//span[contains(text(), 'bundle-option-checkbox" . msq("CheckboxOption") . "')]/../..//div[@class='control']//div[@class='field choice'][2]/input"); // stepKey: selectOption2Product2
		$I->comment("Entering Action Group [enterProductQuantityAndAddToTheCart] StorefrontEnterProductQuantityAndAddToTheCartActionGroup");
		$I->clearField("#qty"); // stepKey: clearTheQuantityFieldEnterProductQuantityAndAddToTheCart
		$I->fillField("#qty", "1"); // stepKey: fillTheProductQuantityEnterProductQuantityAndAddToTheCart
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToButtonEnterProductQuantityAndAddToTheCart
		$I->waitForPageLoad(30); // stepKey: clickOnAddToButtonEnterProductQuantityAndAddToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadEnterProductQuantityAndAddToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageEnterProductQuantityAndAddToTheCart
		$I->comment("Exiting Action Group [enterProductQuantityAndAddToTheCart] StorefrontEnterProductQuantityAndAddToTheCartActionGroup");
		$I->comment("Navigate to checkout");
		$I->comment("Entering Action Group [openCheckoutPage] StorefrontOpenCheckoutPageActionGroup");
		$I->amOnPage("/checkout"); // stepKey: openCheckoutPageOpenCheckoutPage
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPageLoadedOpenCheckoutPage
		$I->comment("Exiting Action Group [openCheckoutPage] StorefrontOpenCheckoutPageActionGroup");
		$I->comment("Click next button to open payment section");
		$I->comment("Entering Action Group [clickNext] StorefrontCheckoutClickNextButtonActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickNextWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickOnNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonClickNextWaitForPageLoad
		$I->comment("Exiting Action Group [clickNext] StorefrontCheckoutClickNextButtonActionGroup");
		$I->comment("Click place order");
		$I->comment("Entering Action Group [placeOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPagePlaceOrder
		$I->comment("Exiting Action Group [placeOrder] ClickPlaceOrderActionGroup");
		$grabOrderNumber = $I->grabTextFrom(".order-number>strong"); // stepKey: grabOrderNumber
		$I->comment("Order review page has address that was created during checkout");
		$I->comment("Entering Action Group [filterOrdersGridById] OpenOrderByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrdersGridById
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrdersGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrdersGridById
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrdersGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrdersGridById
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $grabOrderNumber); // stepKey: fillOrderIdFilterFilterOrdersGridById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrdersGridByIdWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageFilterOrdersGridById
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageFilterOrdersGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrdersGridById
		$I->comment("Exiting Action Group [filterOrdersGridById] OpenOrderByIdActionGroup");
		$I->comment("Open create invoice page");
		$I->comment("Entering Action Group [startInvoice] StartCreateInvoiceFromOrderPageActionGroup");
		$I->click("#order_invoice"); // stepKey: clickInvoiceActionStartInvoice
		$I->waitForPageLoad(30); // stepKey: clickInvoiceActionStartInvoiceWaitForPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_invoice/new/order_id/"); // stepKey: seeNewInvoiceUrlStartInvoice
		$I->see("New Invoice", ".page-header h1.page-title"); // stepKey: seeNewInvoicePageTitleStartInvoice
		$I->comment("Exiting Action Group [startInvoice] StartCreateInvoiceFromOrderPageActionGroup");
		$I->comment("Assert item options display");
		$I->see("50 x " . $I->retrieveEntityField('firstSimpleProduct', 'name', 'test'), "#invoice_item_container .option-value"); // stepKey: seeFirstProductInList
		$I->see("50 x " . $I->retrieveEntityField('secondSimpleProduct', 'name', 'test'), "#invoice_item_container .option-value"); // stepKey: seeSecondProductInList
	}
}
