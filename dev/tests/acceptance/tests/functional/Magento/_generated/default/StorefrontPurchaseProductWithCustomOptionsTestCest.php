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
 * @Title("MC-16462: Admin should be able to sell products with custom options of different types")
 * @Description("Admin should be able to sell products with custom options of different types<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StorefrontPurchaseProductWithCustomOptionsTest.xml<br>")
 * @TestCaseId("MC-16462")
 * @group Catalog
 */
class StorefrontPurchaseProductWithCustomOptionsTestCest
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
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment("Create Simple Product with Custom Options");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$createProductFields['price'] = "17";
		$I->createEntity("createProduct", "hook", "_defaultProduct", ["createCategory"], $createProductFields); // stepKey: createProduct
		$I->updateEntity("createProduct", "hook", "productWithOptions",[]); // stepKey: updateProductWithOption
		$I->comment("Logout customer before in case of it logged in from previous test");
		$I->comment("Entering Action Group [customerLogoutStorefront] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogoutStorefront
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogoutStorefront
		$I->comment("Exiting Action Group [customerLogoutStorefront] StorefrontCustomerLogoutActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Logout customer");
		$I->comment("Entering Action Group [logoutStorefront] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutStorefront
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutStorefront
		$I->comment("Exiting Action Group [logoutStorefront] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Delete product and category");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [clearOrderListingFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: goToGridOrdersPageClearOrderListingFilters
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClearOrderListingFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header .admin__data-grid-filters-current._show", true); // stepKey: clickOnButtonToRemoveFiltersIfPresentClearOrderListingFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitAfterClearFiltersClearOrderListingFilters
		$I->comment("Exiting Action Group [clearOrderListingFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->comment("Entering Action Group [logoutAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAdmin
		$I->comment("Exiting Action Group [logoutAdmin] AdminLogoutActionGroup");
		$I->comment("BIC workaround");
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
	 * @Stories({"Purchase a product with Custom Options of different types"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontPurchaseProductWithCustomOptionsTest(AcceptanceTester $I)
	{
		$I->comment("Login Customer Storefront");
		$I->comment("Entering Action Group [loginCustomerOnStorefront] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginCustomerOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginCustomerOnStorefront
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginCustomerOnStorefront
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginCustomerOnStorefront
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginCustomerOnStorefront
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginCustomerOnStorefront
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginCustomerOnStorefrontWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginCustomerOnStorefront
		$I->comment("Exiting Action Group [loginCustomerOnStorefront] LoginToStorefrontActionGroup");
		$I->comment("Checking the correctness of displayed prices for user parameters");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPage
		$I->seeElement("//label[contains(.,'OptionField')]//span[@data-price-amount='10']"); // stepKey: checkFieldProductOption
		$I->seeElement("//label[contains(.,'OptionArea')]//span[@data-price-amount='1.7']"); // stepKey: checkAreaProductOption
		$I->seeElement("//label[contains(.,'OptionDropDown')]/../div[@class='control']//select//option[@price='0.01']"); // stepKey: checkDropDownProductOption
		$I->seeElement("//label[contains(.,'OptionRadioButtons')]/../div[@class='control']//span[@data-price-amount='99.99']"); // stepKey: checkButtonsProductOption
		$I->seeElement("//label[contains(.,'OptionCheckbox')]/../div[@class='control']//span[@data-price-amount='20.91']"); // stepKey: checkCheckboxProductOptiozn
		$I->seeElement("//label[contains(.,'OptionMultiSelect')]/../div[@class='control']//select//option[@price='1']"); // stepKey: checkMultiSelectProductOption
		$I->seeElement("//span[contains(.,'OptionDate')]/../span[@class='price-notice']//span[@data-price-amount='1234']"); // stepKey: checkDataProductOption
		$I->comment("Generate year");
		$date = new \DateTime();
		$date->setTimestamp(strtotime("Now"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$year = $date->format("Y");

		$date = new \DateTime();
		$date->setTimestamp(strtotime("Now"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$shortYear = $date->format("y");

		$I->comment("Adding items to the checkout");
		$I->fillField("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionField')]/../div[@class='control']//input[@type='text']", "OptionField"); // stepKey: fillProductOptionInputField
		$I->fillField("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionArea')]/../div[@class='control']//textarea", "OptionArea"); // stepKey: fillProductOptionInputArea
		$I->attachFile("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionFile')]/../div[@class='control']//input[@type='file']", "magento.jpg"); // stepKey: fillUploadFile
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionDropDown')]/../div[@class='control']//select", "0.01"); // stepKey: seeProductOptionDropDown
		$I->checkOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionRadioButtons')]/../div[@class='control']//input[@price='99.99']"); // stepKey: seeProductOptionRadioButtons
		$I->checkOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionCheckbox')]/../div[@class='control']//input[@price='20.91']"); // stepKey: seeProductOptionCheckbox
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionMultiSelect')]/../div[@class='control']//select", "1"); // stepKey: selectProductOptionMultiSelect
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//legend[contains(.,'OptionDate')]/../div[@class='control']//select[@data-calendar-role='month']", "01"); // stepKey: selectProductOptionDate
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//legend[contains(.,'OptionDate')]/../div[@class='control']//select[@data-calendar-role='day']", "01"); // stepKey: selectProductOptionDate1
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//legend[contains(.,'OptionDate')]/../div[@class='control']//select[@data-calendar-role='year']", "$year"); // stepKey: selectProductOptionDate2
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//legend[contains(.,'OptionDateTime')]/../div[@class='control']//select[@data-calendar-role='month']", "01"); // stepKey: selectProductOptionDateAndTimeMonth
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//legend[contains(.,'OptionDateTime')]/../div[@class='control']//select[@data-calendar-role='day']", "01"); // stepKey: selectProductOptionDateAndTimeDay
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//legend[contains(.,'OptionDateTime')]/../div[@class='control']//select[@data-calendar-role='year']", "$year"); // stepKey: selectProductOptionDateAndTimeYear
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//legend[contains(.,'OptionDateTime')]/../div[@class='control']//select[@data-calendar-role='hour']", "01"); // stepKey: selectProductOptionDateAndTimeHour
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//legend[contains(.,'OptionDateTime')]/../div[@class='control']//select[@data-calendar-role='minute']", "00"); // stepKey: selectProductOptionDateAndTimeMinute
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//legend[contains(.,'OptionTime')]/../div[@class='control']//select[@data-calendar-role='hour']", "01"); // stepKey: selectProductOptionTimeHour
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//legend[contains(.,'OptionTime')]/../div[@class='control']//select[@data-calendar-role='minute']", "00"); // stepKey: selectProductOptionTimeMinute
		$finalProductPrice = $I->grabTextFrom("div.price-box.price-final_price"); // stepKey: finalProductPrice
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->comment("Checking the correctness of displayed custom options for user parameters on checkout");
		$I->comment("Entering Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->conditionalClick("div.block.items-in-cart", "div.block.items-in-cart", true); // stepKey: exposeMiniCart
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForCartItem
		$I->waitForElement("div.block.items-in-cart.active", 30); // stepKey: waitForCartItemsAreaActive
		$I->waitForPageLoad(30); // stepKey: waitForCartItemsAreaActiveWaitForPageLoad
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), "ol.minicart-items"); // stepKey: seeProductInCart
		$I->conditionalClick("//div[@class='product-item-details']//strong[@class='product-item-name'][text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']//ancestor::div[@class='product-item-details']//div[@class='product options']", "//div[@class='product-item-details']//strong[@class='product-item-name'][text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']//ancestor::div[@class='product-item-details']//div[@class='product options active']", false); // stepKey: exposeProductOptions
		$I->see("OptionField", "//div[@class='product-item-details']//strong[@class='product-item-name'][text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']//ancestor::div[@class='product-item-details']//div[@class='product options active']"); // stepKey: seeProductOptionFieldInput1
		$I->see("OptionArea", "//div[@class='product-item-details']//strong[@class='product-item-name'][text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']//ancestor::div[@class='product-item-details']//div[@class='product options active']"); // stepKey: seeProductOptionAreaInput1
		$I->see("magento.jpg", "//div[@class='product-item-details']//strong[@class='product-item-name'][text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']//ancestor::div[@class='product-item-details']//div[@class='product options active']"); // stepKey: seeProductOptionFileInput1
		$I->seeElement("//div[@class='product-item-details']//strong[@class='product-item-name'][text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']//ancestor::div[@class='product-item-details']//div[@class='product options active']//a[text() = 'magento.jpg']"); // stepKey: seeProductOptionFileInputLink1
		$I->see("OptionValueDropDown1", "//div[@class='product-item-details']//strong[@class='product-item-name'][text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']//ancestor::div[@class='product-item-details']//div[@class='product options active']"); // stepKey: seeProductOptionValueDropdown1Input1
		$I->see("OptionValueRadioButtons1", "//div[@class='product-item-details']//strong[@class='product-item-name'][text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']//ancestor::div[@class='product-item-details']//div[@class='product options active']"); // stepKey: seeProductOptionValueRadioButtons1Input1
		$I->see("OptionValueCheckbox", "//div[@class='product-item-details']//strong[@class='product-item-name'][text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']//ancestor::div[@class='product-item-details']//div[@class='product options active']"); // stepKey: seeProductOptionValueCheckboxInput1
		$I->see("OptionValueMultiSelect1", "//div[@class='product-item-details']//strong[@class='product-item-name'][text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']//ancestor::div[@class='product-item-details']//div[@class='product options active']"); // stepKey: seeproductAttributeOptionsMultiselect1Input1
		$I->see("Jan 1, $year", "//div[@class='product-item-details']//strong[@class='product-item-name'][text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']//ancestor::div[@class='product-item-details']//div[@class='product options active']"); // stepKey: seeProductOptionDateAndTimeInput
		$I->see("1/1/$shortYear, 1:00 AM", "//div[@class='product-item-details']//strong[@class='product-item-name'][text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']//ancestor::div[@class='product-item-details']//div[@class='product options active']"); // stepKey: seeProductOptionDataInput
		$I->see("1:00 AM", "//div[@class='product-item-details']//strong[@class='product-item-name'][text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']//ancestor::div[@class='product-item-details']//div[@class='product options active']"); // stepKey: seeProductOptionTimeInput
		$I->comment("Select shipping method");
		$I->comment("Entering Action Group [selectFlatRateShippingMethod] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->conditionalClick("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", "//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", true); // stepKey: selectFlatRateShippingMethodSelectFlatRateShippingMethod
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForNextButtonSelectFlatRateShippingMethod
		$I->comment("Exiting Action Group [selectFlatRateShippingMethod] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->comment("Entering Action Group [clickNext] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickNextWaitForPageLoad
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonClickNextWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextClickNext
		$I->waitForPageLoad(30); // stepKey: clickNextClickNextWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearClickNext
		$I->comment("Exiting Action Group [clickNext] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->comment("Select payment method");
		$I->comment("Entering Action Group [selectPaymentMethod] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectPaymentMethod
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectPaymentMethod
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectPaymentMethod
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectPaymentMethod
		$I->comment("Exiting Action Group [selectPaymentMethod] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Place Order");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickPlaceOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutClickPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageClickPlaceOrder
		$I->comment("Exiting Action Group [clickPlaceOrder] ClickPlaceOrderActionGroup");
		$grabOrderNumber = $I->grabTextFrom(".order-number>strong"); // stepKey: grabOrderNumber
		$I->comment("Login to Admin and open Order");
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->comment("Entering Action Group [filterByOrderId] FilterOrderGridByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterByOrderId
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterByOrderId
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterByOrderId
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterByOrderIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterByOrderId
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterByOrderId
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterByOrderIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterByOrderId
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$grabOrderNumber"); // stepKey: fillOrderIdFilterFilterByOrderId
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterByOrderId
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterByOrderIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterByOrderId
		$I->comment("Exiting Action Group [filterByOrderId] FilterOrderGridByIdActionGroup");
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: clickOrderRow
		$I->waitForPageLoad(60); // stepKey: clickOrderRowWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageOpened
		$I->comment("Checking the correctness of displayed custom options for user parameters on Order");
		$I->see("OptionField", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderProductOptionField
		$I->see("OptionArea", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderProductOptionArea
		$I->see("magento.jpg", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderProductOptionFile
		$I->seeElement("//table[contains(@class, 'edit-order-table')]//td[contains(@class, 'col-product')]//a[text() = 'magento.jpg']"); // stepKey: seeAdminOrderProductOptionFileLink
		$I->see("OptionValueDropDown1", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderProductOptionValueDropdown1
		$I->see("OptionValueRadioButtons1", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderProductOptionValueRadioButton1
		$I->see("OptionValueCheckbox", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderProductOptionValueCheckbox
		$I->see("OptionValueMultiSelect1", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderproductAttributeOptionsMultiselect1
		$I->see("Jan 1, $year", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderProductOptionDateAndTime
		$I->see("1/1/$shortYear, 1:00 AM", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderProductOptionData
		$I->see("1:00 AM", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderProductOptionTime
		$I->comment("Reorder and Checking the correctness of displayed custom options for user parameters on Order and correctness of displayed price Subtotal");
		$I->click("#order_reorder"); // stepKey: clickReorder
		$I->waitForPageLoad(30); // stepKey: clickReorderWaitForPageLoad
		$I->comment("Entering Action Group [selectBillingMethod] AdminCheckoutSelectCheckMoneyOrderBillingMethodActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectBillingMethod
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectBillingMethod
		$I->conditionalClick("//div[@id='order-billing_method']//dl[@class='admin__payment-methods']//dt//label[contains(., 'Check / Money order')]/..//input", "//div[@id='order-billing_method']//dl[@class='admin__payment-methods']//dt//label[contains(., 'Check / Money order')]/..//input", true); // stepKey: selectCheckmoBillingMethodSelectBillingMethod
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterBillingMethodSelectionSelectBillingMethod
		$I->comment("Exiting Action Group [selectBillingMethod] AdminCheckoutSelectCheckMoneyOrderBillingMethodActionGroup");
		$I->comment("Entering Action Group [trySubmitOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->click("#submit_order_top_button"); // stepKey: clickSubmitOrderTrySubmitOrder
		$I->waitForPageLoad(30); // stepKey: clickSubmitOrderTrySubmitOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoadTrySubmitOrder
		$I->comment("Exiting Action Group [trySubmitOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->see("OptionField", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderProductOptionField1
		$I->see("OptionArea", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderProductOptionArea1
		$I->see("magento.jpg", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderProductOptionFile1
		$I->seeElement("//table[contains(@class, 'edit-order-table')]//td[contains(@class, 'col-product')]//a[text() = 'magento.jpg']"); // stepKey: seeAdminOrderProductOptionFileLink1
		$I->see("OptionValueDropDown1", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderProductOptionValueDropdown11
		$I->see("OptionValueRadioButtons1", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderProductOptionValueRadioButton11
		$I->see("OptionValueCheckbox", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderProductOptionValueCheckbox1
		$I->see("OptionValueMultiSelect1", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderproductAttributeOptionsMultiselect11
		$I->see("Jan 1, $year", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderProductOptionDateAndTime1
		$I->see("1/1/$shortYear, 1:00 AM", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderProductOptionData1
		$I->see("1:00 AM", ".edit-order-table .col-product .item-options"); // stepKey: seeAdminOrderProductOptionTime1
		$I->see($finalProductPrice, ".order-subtotal-table tbody tr.col-0>td span.price"); // stepKey: seeOrderSubTotal
		$I->comment("Go to Customer Order Page and Checking the correctness of displayed custom options for user parameters on Order");
		$I->amOnPage("sales/order/view/order_id/{$grabOrderNumber}"); // stepKey: amOnOrderPage
		$I->see("OptionField", "//strong[contains(@class, 'product-item-name') and normalize-space(.)='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']/following-sibling::*[contains(@class, 'item-options')]/dt[normalize-space(.)='OptionField']/following-sibling::dd[normalize-space(.)='OptionField']"); // stepKey: seeStorefontOrderProductOptionField1
		$I->see("OptionArea", "//strong[contains(@class, 'product-item-name') and normalize-space(.)='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']/following-sibling::*[contains(@class, 'item-options')]/dt[normalize-space(.)='OptionArea']/following-sibling::dd[normalize-space(.)='OptionArea']"); // stepKey: seeStorefontOrderProductOptionArea1
		$I->see("magento.jpg", "//strong[contains(@class, 'product-item-name') and normalize-space(.)='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']/following-sibling::*[contains(@class, 'item-options')]/dt[normalize-space(.)='OptionFile']/following-sibling::dd[contains(.,'magento.jpg')]"); // stepKey: seeStorefontOrderProductOptionFile1
		$I->seeElement("//strong[contains(@class, 'product-item-name') and normalize-space(.)='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']/following-sibling::*[contains(@class, 'item-options')]/dt[normalize-space(.)='OptionFile']/following-sibling::dd//a[text() = 'magento.jpg']"); // stepKey: seeStorefontOrderProductOptionFileLink1
		$I->see("OptionValueDropDown1", "//strong[contains(@class, 'product-item-name') and normalize-space(.)='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']/following-sibling::*[contains(@class, 'item-options')]/dt[normalize-space(.)='OptionDropDown']/following-sibling::dd[normalize-space(.)='OptionValueDropDown1']"); // stepKey: seeStorefontOrderProductOptionValueDropdown11
		$I->see("OptionValueRadioButtons1", "//strong[contains(@class, 'product-item-name') and normalize-space(.)='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']/following-sibling::*[contains(@class, 'item-options')]/dt[normalize-space(.)='OptionRadioButtons']/following-sibling::dd[normalize-space(.)='OptionValueRadioButtons1']"); // stepKey: seeStorefontOrderProductOptionValueRadioButtons11
		$I->see("OptionValueCheckbox", "//strong[contains(@class, 'product-item-name') and normalize-space(.)='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']/following-sibling::*[contains(@class, 'item-options')]/dt[normalize-space(.)='OptionCheckbox']/following-sibling::dd[normalize-space(.)='OptionValueCheckbox']"); // stepKey: seeStorefontOrderProductOptionValueCheckbox1
		$I->see("OptionValueMultiSelect1", "//strong[contains(@class, 'product-item-name') and normalize-space(.)='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']/following-sibling::*[contains(@class, 'item-options')]/dt[normalize-space(.)='OptionMultiSelect']/following-sibling::dd[normalize-space(.)='OptionValueMultiSelect1']"); // stepKey: seeStorefontOrderproductAttributeOptionsMultiselect11
		$I->see("Jan 1, $year", "//strong[contains(@class, 'product-item-name') and normalize-space(.)='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']/following-sibling::*[contains(@class, 'item-options')]/dt[normalize-space(.)='OptionDate']/following-sibling::dd[normalize-space(.)='Jan 1, $year']"); // stepKey: seeStorefontOrderProductOptionDateAndTime1
		$I->see("1/1/$shortYear, 1:00 AM", "//strong[contains(@class, 'product-item-name') and normalize-space(.)='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']/following-sibling::*[contains(@class, 'item-options')]/dt[normalize-space(.)='OptionDateTime']/following-sibling::dd[normalize-space(.)='1/1/$shortYear, 1:00 AM']"); // stepKey: seeStorefontOrderProductOptionData1
		$I->see("1:00 AM", "//strong[contains(@class, 'product-item-name') and normalize-space(.)='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']/following-sibling::*[contains(@class, 'item-options')]/dt[normalize-space(.)='OptionTime']/following-sibling::dd[normalize-space(.)='1:00 AM']"); // stepKey: seeStorefontOrderProductOptionTime1
	}
}
