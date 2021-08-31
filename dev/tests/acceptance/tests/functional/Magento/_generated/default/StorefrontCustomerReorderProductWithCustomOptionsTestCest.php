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
 * @Title("MC-42899: Make reorder as customer on frontend")
 * @Description("Make reorder as customer on Frontend with simple product custom options<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/StorefrontCustomerReorderProductWithCustomOptionsTest.xml<br>")
 * @TestCaseId("MC-42899")
 * @group sales
 */
class StorefrontCustomerReorderProductWithCustomOptionsTestCest
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
		$I->comment("Login As Admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create Customer");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment("Create Simple Category");
		$I->createEntity("initialCategoryEntity", "hook", "_defaultCategory", [], []); // stepKey: initialCategoryEntity
		$I->comment("Create Simple Product");
		$I->createEntity("initialSimpleProduct", "hook", "defaultSimpleProduct", [], []); // stepKey: initialSimpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("initialCategoryEntity", "hook"); // stepKey: deleteDefaultCategory
		$I->deleteEntity("initialSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
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
	 * @Stories({"Reorder product with custom options"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Sales"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCustomerReorderProductWithCustomOptionsTest(AcceptanceTester $I)
	{
		$I->comment("Search default simple product in the grid");
		$I->comment("Entering Action Group [openProductCatalogPage] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageOpenProductCatalogPage
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadOpenProductCatalogPage
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentOpenProductCatalogPage
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentOpenProductCatalogPageWaitForPageLoad
		$I->comment("Exiting Action Group [openProductCatalogPage] AdminClearFiltersActionGroup");
		$I->comment("Entering Action Group [clickFirstRowToOpenDefaultSimpleProduct] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('initialSimpleProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowClickFirstRowToOpenDefaultSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadClickFirstRowToOpenDefaultSimpleProduct
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('initialSimpleProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageClickFirstRowToOpenDefaultSimpleProduct
		$I->comment("Exiting Action Group [clickFirstRowToOpenDefaultSimpleProduct] OpenEditProductOnBackendActionGroup");
		$I->comment("Open custom option panel");
		$I->click("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']"); // stepKey: openCustomizableOptions
		$I->waitForPageLoad(30); // stepKey: waitForCustomOptionsOpen
		$I->comment("Add First Drop Down Custom Options");
		$I->comment("Entering Action Group [addProductCustomDropDownOptionFirst] AdminAddProductCustomOptionActionGroup");
		$I->scrollTo("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']"); // stepKey: scrollToCustomizableOptionsSectionAddProductCustomDropDownOptionFirst
		$I->waitForPageLoad(30); // stepKey: waitForScrollingAddProductCustomDropDownOptionFirst
		$I->click("button[data-index='button_add']"); // stepKey: clickAddOptionsAddProductCustomDropDownOptionFirst
		$I->waitForPageLoad(30); // stepKey: clickAddOptionsAddProductCustomDropDownOptionFirstWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddProductPageLoadAddProductCustomDropDownOptionFirst
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, '_required')]//input", "OptionDropDown"); // stepKey: fillInOptionTitleAddProductCustomDropDownOptionFirst
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__action-multiselect-text')]"); // stepKey: clickOptionTypeParentAddProductCustomDropDownOptionFirst
		$I->waitForPageLoad(30); // stepKey: waitForDropdownOpenAddProductCustomDropDownOptionFirst
		$I->click("//*[@data-index='custom_options']//label[text()='Drop-down'][ancestor::*[contains(@class, '_active')]]"); // stepKey: clickOptionTypeAddProductCustomDropDownOptionFirst
		$I->comment("Exiting Action Group [addProductCustomDropDownOptionFirst] AdminAddProductCustomOptionActionGroup");
		$I->comment("Entering Action Group [addTitleAndPriceValueToCustomDropDownOptionFirst] AdminAddTitleAndPriceValueToCustomOptionActionGroup");
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[@data-action='add_new_row']"); // stepKey: clickAddValueAddTitleAndPriceValueToCustomDropDownOptionFirst
		$I->waitForPageLoad(30); // stepKey: clickAddValueAddTitleAndPriceValueToCustomDropDownOptionFirstWaitForPageLoad
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__control-table')]//tbody/tr[last()]//*[@data-index='title']//input", "OptionValueDropDown1"); // stepKey: fillInValueTitleAddTitleAndPriceValueToCustomDropDownOptionFirst
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__control-table')]//tbody/tr[last()]//*[@data-index='price']//input", "0.01"); // stepKey: fillInValuePriceAddTitleAndPriceValueToCustomDropDownOptionFirst
		$I->comment("Exiting Action Group [addTitleAndPriceValueToCustomDropDownOptionFirst] AdminAddTitleAndPriceValueToCustomOptionActionGroup");
		$I->comment("Add Custom file option");
		$I->comment("Entering Action Group [addFileOption] AddProductCustomOptionFileActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "button[data-index='button_add']", false); // stepKey: openCustomOptionSectionAddFileOption
		$I->waitForPageLoad(30); // stepKey: openCustomOptionSectionAddFileOptionWaitForPageLoad
		$I->click("button[data-index='button_add']"); // stepKey: clickAddOptionAddFileOption
		$I->waitForPageLoad(30); // stepKey: clickAddOptionAddFileOptionWaitForPageLoad
		$I->waitForElementVisible("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, '_required')]//input", 30); // stepKey: waitForOptionAddFileOption
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, '_required')]//input", "OptionFile"); // stepKey: fillTitleAddFileOption
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__action-multiselect-text')]"); // stepKey: openTypeSelectAddFileOption
		$I->click("//*[@data-index='custom_options']//label[text()='File'][ancestor::*[contains(@class, '_active')]]"); // stepKey: selectTypeFileAddFileOption
		$I->waitForElementVisible("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'OptionFile')]/ancestor::tr//*[@data-index='price']//input", 30); // stepKey: waitForElementsAddFileOption
		$I->fillField("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'OptionFile')]/ancestor::tr//*[@data-index='price']//input", "9.99"); // stepKey: fillPriceAddFileOption
		$I->selectOption("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'OptionFile')]/ancestor::tr//*[@data-index='price_type']//select", "fixed"); // stepKey: selectPriceTypeAddFileOption
		$I->fillField("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'OptionFile')]/ancestor::tr//*[@data-index='file_extension']//input", "png, jpg, gif"); // stepKey: fillCompatibleExtensionsAddFileOption
		$I->comment("Exiting Action Group [addFileOption] AddProductCustomOptionFileActionGroup");
		$I->comment("Add Second Drop Down Custom Options");
		$I->comment("As per issue both drop-down are fixed valued so used again ProductOptionValueDropdown1 DataEntity");
		$I->comment("Entering Action Group [addProductCustomDropDownOptionSecond] AdminAddProductCustomOptionActionGroup");
		$I->scrollTo("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']"); // stepKey: scrollToCustomizableOptionsSectionAddProductCustomDropDownOptionSecond
		$I->waitForPageLoad(30); // stepKey: waitForScrollingAddProductCustomDropDownOptionSecond
		$I->click("button[data-index='button_add']"); // stepKey: clickAddOptionsAddProductCustomDropDownOptionSecond
		$I->waitForPageLoad(30); // stepKey: clickAddOptionsAddProductCustomDropDownOptionSecondWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddProductPageLoadAddProductCustomDropDownOptionSecond
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, '_required')]//input", "OptionDropDownWithLongTitles"); // stepKey: fillInOptionTitleAddProductCustomDropDownOptionSecond
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__action-multiselect-text')]"); // stepKey: clickOptionTypeParentAddProductCustomDropDownOptionSecond
		$I->waitForPageLoad(30); // stepKey: waitForDropdownOpenAddProductCustomDropDownOptionSecond
		$I->click("//*[@data-index='custom_options']//label[text()='Drop-down'][ancestor::*[contains(@class, '_active')]]"); // stepKey: clickOptionTypeAddProductCustomDropDownOptionSecond
		$I->comment("Exiting Action Group [addProductCustomDropDownOptionSecond] AdminAddProductCustomOptionActionGroup");
		$I->comment("Entering Action Group [addTitleAndPriceValueToCustomDropDownOptionSecond] AdminAddTitleAndPriceValueToCustomOptionActionGroup");
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[@data-action='add_new_row']"); // stepKey: clickAddValueAddTitleAndPriceValueToCustomDropDownOptionSecond
		$I->waitForPageLoad(30); // stepKey: clickAddValueAddTitleAndPriceValueToCustomDropDownOptionSecondWaitForPageLoad
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__control-table')]//tbody/tr[last()]//*[@data-index='title']//input", "OptionValueDropDown2"); // stepKey: fillInValueTitleAddTitleAndPriceValueToCustomDropDownOptionSecond
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__control-table')]//tbody/tr[last()]//*[@data-index='price']//input", "0.01"); // stepKey: fillInValuePriceAddTitleAndPriceValueToCustomDropDownOptionSecond
		$I->comment("Exiting Action Group [addTitleAndPriceValueToCustomDropDownOptionSecond] AdminAddTitleAndPriceValueToCustomOptionActionGroup");
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
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Login to storefront as Customer");
		$I->comment("Entering Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerLogin
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerLogin
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerLogin
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailCustomerLogin
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordCustomerLogin
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerLogin
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerLoginWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerLogin
		$I->comment("Exiting Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->comment("Place Order as Customer");
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('initialSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Select Option From First DropDown option");
		$I->comment("Entering Action Group [selectFirstOption] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionDropDown')]/../div[@class='control']//select", "OptionValueDropDown1"); // stepKey: fillDropDownAttributeOptionSelectFirstOption
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectFirstOption
		$I->comment("Exiting Action Group [selectFirstOption] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->comment("Attach file option");
		$I->comment("Entering Action Group [selectAndAttachFile] StorefrontAttachOptionFileActionGroup");
		$I->attachFile("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionFile')]/../div[@class='control']//input[@type='file']", "magento-logo.png"); // stepKey: attachFileSelectAndAttachFile
		$I->comment("Exiting Action Group [selectAndAttachFile] StorefrontAttachOptionFileActionGroup");
		$I->comment("Select Option From Second DropDown option");
		$I->comment("Entering Action Group [selectSecondOption] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionDropDownWithLongTitles')]/../div[@class='control']//select", "OptionValueDropDown2"); // stepKey: fillDropDownAttributeOptionSelectSecondOption
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectSecondOption
		$I->comment("Exiting Action Group [selectSecondOption] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->comment("Add Product to Card");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('initialSimpleProduct', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageAddProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartAddProductToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->comment("Entering Action Group [openCart] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageOpenCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenCart
		$I->comment("Exiting Action Group [openCart] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [placeOrder] PlaceOrderWithLoggedUserActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForCartTotalsLoadedPlaceOrder
		$I->waitForElementVisible(".grand.totals .amount .price", 30); // stepKey: waitForCartGrandTotalVisiblePlaceOrder
		$I->waitForElementVisible(".action.primary.checkout span", 30); // stepKey: waitProceedToCheckoutPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitProceedToCheckoutPlaceOrderWaitForPageLoad
		$I->click(".action.primary.checkout span"); // stepKey: clickProceedToCheckoutPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickProceedToCheckoutPlaceOrderWaitForPageLoad
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input"); // stepKey: selectShippingMethodPlaceOrder
		$I->waitForElement("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonPlaceOrderWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickNextPlaceOrderWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedPlaceOrder
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlPlaceOrder
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderPlaceOrderWaitForPageLoad
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPagePlaceOrder
		$I->comment("Exiting Action Group [placeOrder] PlaceOrderWithLoggedUserActionGroup");
		$grabOrderNumber = $I->grabTextFrom(".order-number>strong"); // stepKey: grabOrderNumber
		$I->comment("Log out from storefront as Customer");
		$I->comment("Entering Action Group [customerLogOut] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogOut
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogOut
		$I->comment("Exiting Action Group [customerLogOut] StorefrontCustomerLogoutActionGroup");
		$I->comment("Again Login As Admin");
		$I->comment("Entering Action Group [loginAsAdminForSubmitShipment] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdminForSubmitShipment
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdminForSubmitShipment
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdminForSubmitShipment
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdminForSubmitShipment
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminForSubmitShipmentWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdminForSubmitShipment
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdminForSubmitShipment
		$I->comment("Exiting Action Group [loginAsAdminForSubmitShipment] AdminLoginActionGroup");
		$I->comment("Open order");
		$I->comment("Entering Action Group [openOrderForCreatingShipment] OpenOrderByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageOpenOrderForCreatingShipment
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageOpenOrderForCreatingShipment
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersOpenOrderForCreatingShipment
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersOpenOrderForCreatingShipmentWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersOpenOrderForCreatingShipment
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersOpenOrderForCreatingShipment
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersOpenOrderForCreatingShipmentWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersOpenOrderForCreatingShipment
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $grabOrderNumber); // stepKey: fillOrderIdFilterOpenOrderForCreatingShipment
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersOpenOrderForCreatingShipment
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersOpenOrderForCreatingShipmentWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageOpenOrderForCreatingShipment
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageOpenOrderForCreatingShipmentWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedOpenOrderForCreatingShipment
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersOpenOrderForCreatingShipment
		$I->comment("Exiting Action Group [openOrderForCreatingShipment] OpenOrderByIdActionGroup");
		$I->comment("Create Shipment for the order");
		$I->comment("Entering Action Group [startCreateShipment] GoToShipmentIntoOrderActionGroup");
		$I->click("#order_ship"); // stepKey: clickShipActionStartCreateShipment
		$I->waitForPageLoad(30); // stepKey: clickShipActionStartCreateShipmentWaitForPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/order_shipment/new/order_id/"); // stepKey: seeOrderShipmentUrlStartCreateShipment
		$I->see("New Shipment", ".page-header h1.page-title"); // stepKey: seePageNameNewInvoicePageStartCreateShipment
		$I->comment("Exiting Action Group [startCreateShipment] GoToShipmentIntoOrderActionGroup");
		$I->comment("Entering Action Group [submitShipment] SubmitShipmentIntoOrderActionGroup");
		$I->click("button.action-default.save.submit-button"); // stepKey: clickSubmitShipmentSubmitShipment
		$I->waitForPageLoad(60); // stepKey: clickSubmitShipmentSubmitShipmentWaitForPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/"); // stepKey: seeViewOrderPageShippingSubmitShipment
		$I->see("The shipment has been created.", "div.message-success"); // stepKey: seeShipmentCreateSuccessSubmitShipment
		$I->comment("Exiting Action Group [submitShipment] SubmitShipmentIntoOrderActionGroup");
		$I->comment("Login to storefront as Customer for Reorder");
		$I->comment("Entering Action Group [customerLoginForReorder] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerLoginForReorder
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerLoginForReorder
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerLoginForReorder
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailCustomerLoginForReorder
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordCustomerLoginForReorder
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerLoginForReorder
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerLoginForReorderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerLoginForReorder
		$I->comment("Exiting Action Group [customerLoginForReorder] LoginToStorefrontActionGroup");
		$I->comment("Make reorder");
		$I->comment("Entering Action Group [makeReorder] StorefrontCustomerReorderActionGroup");
		$I->amOnPage("/customer/account/"); // stepKey: goToCustomerDashboardPageMakeReorder
		$I->waitForPageLoad(30); // stepKey: waitForCustomerDashboardPageLoadMakeReorder
		$I->click("//div[@id='block-collapsible-nav']//a[text()='My Orders']"); // stepKey: navigateToOrdersMakeReorder
		$I->waitForPageLoad(60); // stepKey: navigateToOrdersMakeReorderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageLoadMakeReorder
		$I->click("//td[contains(text(),'{$grabOrderNumber}')]/following-sibling::td[contains(@class,'col') and contains(@class,'actions')]/a[contains(@class, 'order')]"); // stepKey: clickReorderBtnMakeReorder
		$I->waitForPageLoad(30); // stepKey: clickReorderBtnMakeReorderWaitForPageLoad
		$I->comment("Exiting Action Group [makeReorder] StorefrontCustomerReorderActionGroup");
		$I->comment("Entering Action Group [placeReorder] PlaceOrderWithLoggedUserActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForCartTotalsLoadedPlaceReorder
		$I->waitForElementVisible(".grand.totals .amount .price", 30); // stepKey: waitForCartGrandTotalVisiblePlaceReorder
		$I->waitForElementVisible(".action.primary.checkout span", 30); // stepKey: waitProceedToCheckoutPlaceReorder
		$I->waitForPageLoad(30); // stepKey: waitProceedToCheckoutPlaceReorderWaitForPageLoad
		$I->click(".action.primary.checkout span"); // stepKey: clickProceedToCheckoutPlaceReorder
		$I->waitForPageLoad(30); // stepKey: clickProceedToCheckoutPlaceReorderWaitForPageLoad
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input"); // stepKey: selectShippingMethodPlaceReorder
		$I->waitForElement("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonPlaceReorder
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonPlaceReorderWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextPlaceReorder
		$I->waitForPageLoad(30); // stepKey: clickNextPlaceReorderWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedPlaceReorder
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlPlaceReorder
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonPlaceReorder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonPlaceReorderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderPlaceReorder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderPlaceReorderWaitForPageLoad
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPagePlaceReorder
		$I->comment("Exiting Action Group [placeReorder] PlaceOrderWithLoggedUserActionGroup");
	}
}
