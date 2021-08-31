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
 * @Title("MC-38412: Same shipping address is not repeating multiple times in storefront checkout when Reordered")
 * @Description("Same shipping address is not repeating multiple times in storefront checkout when Reordered<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminReorderAddressNotSavedInAddressBookTest.xml<br>")
 * @TestCaseId("MC-38412")
 * @group sales
 */
class AdminReorderAddressNotSavedInAddressBookTestCest
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
		$I->createEntity("category", "hook", "ApiCategory", [], []); // stepKey: category
		$I->createEntity("product", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: product
		$I->createEntity("customer", "hook", "Simple_Customer_Without_Address", [], []); // stepKey: customer
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefrontAccount
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefrontAccount
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'hook')); // stepKey: fillEmailLoginToStorefrontAccount
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'hook')); // stepKey: fillPasswordLoginToStorefrontAccount
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefrontAccount
		$I->comment("Exiting Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("product", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogout
		$I->comment("Exiting Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Features({"Sales"})
	 * @Stories({"Reorder"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminReorderAddressNotSavedInAddressBookTest(AcceptanceTester $I)
	{
		$I->comment("Create order for registered customer");
		$I->comment("Entering Action Group [addSimpleProductToOrder] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('product', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddSimpleProductToOrder
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: addToCartAddSimpleProductToOrderWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddSimpleProductToOrder
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddSimpleProductToOrder
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSimpleProductToOrder
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddSimpleProductToOrder
		$I->see("You added " . $I->retrieveEntityField('product', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddSimpleProductToOrder
		$I->comment("Exiting Action Group [addSimpleProductToOrder] AddSimpleProductToCartActionGroup");
		$I->comment("Entering Action Group [openCheckoutPage] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityOpenCheckoutPage
		$I->wait(5); // stepKey: waitMinicartRenderingOpenCheckoutPage
		$I->click("a.showcart"); // stepKey: clickCartOpenCheckoutPage
		$I->waitForPageLoad(60); // stepKey: clickCartOpenCheckoutPageWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutOpenCheckoutPage
		$I->waitForPageLoad(30); // stepKey: goToCheckoutOpenCheckoutPageWaitForPageLoad
		$I->comment("Exiting Action Group [openCheckoutPage] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Entering Action Group [fillAddressForm] LoggedInUserCheckoutFillingShippingSectionActionGroup");
		$I->fillField("input[name=firstname]", "John"); // stepKey: enterFirstNameFillAddressForm
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: enterLastNameFillAddressForm
		$I->fillField("input[name='street[0]']", "7700 W Parmer Ln"); // stepKey: enterStreetFillAddressForm
		$I->fillField("input[name=city]", "Austin"); // stepKey: enterCityFillAddressForm
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegionFillAddressForm
		$I->fillField("input[name=postcode]", "78729"); // stepKey: enterPostcodeFillAddressForm
		$I->fillField("input[name=telephone]", "1234568910"); // stepKey: enterTelephoneFillAddressForm
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskFillAddressForm
		$I->click("//*[@id='checkout-shipping-method-load']//input[@class='radio']"); // stepKey: selectFirstShippingMethodFillAddressForm
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonFillAddressForm
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonFillAddressFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingLoadingMaskFillAddressForm
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextFillAddressForm
		$I->waitForPageLoad(30); // stepKey: clickNextFillAddressFormWaitForPageLoad
		$I->waitForElementVisible("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedFillAddressForm
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlFillAddressForm
		$I->comment("Exiting Action Group [fillAddressForm] LoggedInUserCheckoutFillingShippingSectionActionGroup");
		$I->comment("Entering Action Group [clickPlaceOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutClickPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageClickPlaceOrder
		$I->comment("Exiting Action Group [clickPlaceOrder] ClickPlaceOrderActionGroup");
		$grabOrderNumber = $I->grabTextFrom(".order-number>strong"); // stepKey: grabOrderNumber
		$I->comment("Reorder created order");
		$I->comment("Entering Action Group [openOrderById] OpenOrderByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageOpenOrderById
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageOpenOrderById
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersOpenOrderById
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersOpenOrderByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersOpenOrderById
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersOpenOrderById
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersOpenOrderByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersOpenOrderById
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $grabOrderNumber); // stepKey: fillOrderIdFilterOpenOrderById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersOpenOrderById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersOpenOrderByIdWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageOpenOrderById
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageOpenOrderByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedOpenOrderById
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersOpenOrderById
		$I->comment("Exiting Action Group [openOrderById] OpenOrderByIdActionGroup");
		$I->comment("Entering Action Group [startReorder] AdminStartReorderFromOrderPageActionGroup");
		$I->click("#order_reorder"); // stepKey: clickReorderStartReorder
		$I->waitForPageLoad(30); // stepKey: clickReorderStartReorderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitPageLoadStartReorder
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForPageTitleStartReorder
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeCreateNewOrderPageTitleStartReorder
		$I->comment("Exiting Action Group [startReorder] AdminStartReorderFromOrderPageActionGroup");
		$I->comment("Entering Action Group [submitOrder] AdminSubmitOrderActionGroup");
		$I->scrollTo("#submit_order_top_button"); // stepKey: scrollToSubmitButtonSubmitOrder
		$I->waitForPageLoad(60); // stepKey: scrollToSubmitButtonSubmitOrderWaitForPageLoad
		$I->click("#submit_order_top_button"); // stepKey: submitOrderSubmitOrder
		$I->waitForPageLoad(60); // stepKey: submitOrderSubmitOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSubmitOrder
		$I->see("You created the order."); // stepKey: seeSuccessMessageForOrderSubmitOrder
		$I->comment("Exiting Action Group [submitOrder] AdminSubmitOrderActionGroup");
		$I->comment("Assert no additional addresses saved");
		$I->comment("Entering Action Group [assertAddresses] AssertStorefrontCustomerHasNoOtherAddressesActionGroup");
		$I->amOnPage("/customer/address/"); // stepKey: goToAddressPageAssertAddresses
		$I->waitForText("You have no other address entries in your address book.", 30, ".block-addresses-list"); // stepKey: assertOtherAddressesAssertAddresses
		$I->comment("Exiting Action Group [assertAddresses] AssertStorefrontCustomerHasNoOtherAddressesActionGroup");
	}
}
