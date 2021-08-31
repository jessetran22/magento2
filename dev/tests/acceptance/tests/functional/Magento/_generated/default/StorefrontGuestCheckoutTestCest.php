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
 * @Title("MC-12825: Guest Checkout - guest should be able to place an order")
 * @Description("Should be able to place an order as a Guest<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontGuestCheckoutTest/StorefrontGuestCheckoutTest.xml<br>")
 * @TestCaseId("MC-12825")
 * @group checkout
 */
class StorefrontGuestCheckoutTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
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
	 * @Features({"Checkout"})
	 * @Stories({"Checkout via Guest Checkout"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontGuestCheckoutTest(AcceptanceTester $I)
	{
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1
		$I->comment("Entering Action Group [hoverProduct] StorefrontHoverProductOnCategoryPageActionGroup");
		$I->moveMouseOver(".product-item-info"); // stepKey: hoverOverProductHoverProduct
		$I->comment("Exiting Action Group [hoverProduct] StorefrontHoverProductOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [addToCart] StorefrontClickAddToCartButtonActionGroup");
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddToCart
		$I->waitForPageLoad(30); // stepKey: waitAddToCartAddToCart
		$I->comment("Exiting Action Group [addToCart] StorefrontClickAddToCartButtonActionGroup");
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForProductAdded
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success"); // stepKey: seeAddedToCartMessage
		$I->see("1", "span.counter-number"); // stepKey: seeCartQuantity
		$I->comment("Entering Action Group [guestGoToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGuestGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGuestGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGuestGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGuestGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGuestGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGuestGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [guestGoToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Entering Action Group [guestCheckoutFillingShippingSection] GuestCheckoutFillingShippingSectionActionGroup");
		$I->waitForElementVisible("input[id*=customer-email]", 30); // stepKey: waitForEmailFieldGuestCheckoutFillingShippingSection
		$I->fillField("input[id*=customer-email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: enterEmailGuestCheckoutFillingShippingSection
		$I->fillField("input[name=firstname]", "John"); // stepKey: enterFirstNameGuestCheckoutFillingShippingSection
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: enterLastNameGuestCheckoutFillingShippingSection
		$I->fillField("input[name='street[0]']", "7700 W Parmer Ln"); // stepKey: enterStreetGuestCheckoutFillingShippingSection
		$I->fillField("input[name=city]", "Austin"); // stepKey: enterCityGuestCheckoutFillingShippingSection
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegionGuestCheckoutFillingShippingSection
		$I->fillField("input[name=postcode]", "78729"); // stepKey: enterPostcodeGuestCheckoutFillingShippingSection
		$I->fillField("input[name=telephone]", "1234568910"); // stepKey: enterTelephoneGuestCheckoutFillingShippingSection
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskGuestCheckoutFillingShippingSection
		$I->waitForElement("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input", 30); // stepKey: waitForShippingMethodGuestCheckoutFillingShippingSection
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input"); // stepKey: selectShippingMethodGuestCheckoutFillingShippingSection
		$I->waitForElement("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGuestCheckoutFillingShippingSection
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGuestCheckoutFillingShippingSectionWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGuestCheckoutFillingShippingSection
		$I->waitForPageLoad(30); // stepKey: clickNextGuestCheckoutFillingShippingSectionWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedGuestCheckoutFillingShippingSection
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlGuestCheckoutFillingShippingSection
		$I->comment("Exiting Action Group [guestCheckoutFillingShippingSection] GuestCheckoutFillingShippingSectionActionGroup");
		$I->comment("Entering Action Group [guestSelectCheckMoneyOrderPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskGuestSelectCheckMoneyOrderPayment
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGuestSelectCheckMoneyOrderPayment
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodGuestSelectCheckMoneyOrderPayment
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionGuestSelectCheckMoneyOrderPayment
		$I->comment("Exiting Action Group [guestSelectCheckMoneyOrderPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Entering Action Group [guestSeeAddress] CheckBillingAddressInCheckoutActionGroup");
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedGuestSeeAddress
		$I->see("John", ".payment-method._active div.billing-address-details"); // stepKey: assertBillingAddressFirstNameGuestSeeAddress
		$I->see("Doe", ".payment-method._active div.billing-address-details"); // stepKey: assertBillingAddressLastNameGuestSeeAddress
		$I->see("7700 W Parmer Ln", ".payment-method._active div.billing-address-details"); // stepKey: assertBillingAddressStreetGuestSeeAddress
		$I->see("Austin", ".payment-method._active div.billing-address-details"); // stepKey: assertBillingAddressCityGuestSeeAddress
		$I->see("Texas", ".payment-method._active div.billing-address-details"); // stepKey: assertBillingAddressStateGuestSeeAddress
		$I->see("78729", ".payment-method._active div.billing-address-details"); // stepKey: assertBillingAddressPostcodeGuestSeeAddress
		$I->see("1234568910", ".payment-method._active div.billing-address-details"); // stepKey: assertBillingAddressTelephoneGuestSeeAddress
		$I->comment("Exiting Action Group [guestSeeAddress] CheckBillingAddressInCheckoutActionGroup");
		$I->comment("Entering Action Group [guestPlaceorder] CheckoutPlaceOrderActionGroup");
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonGuestPlaceorder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonGuestPlaceorderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderGuestPlaceorder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderGuestPlaceorderWaitForPageLoad
		$I->see("Your order # is:", "div.checkout-success"); // stepKey: seeOrderNumberGuestPlaceorder
		$I->see("We'll email you an order confirmation with details and tracking info.", "div.checkout-success"); // stepKey: seeEmailYouGuestPlaceorder
		$I->comment("Exiting Action Group [guestPlaceorder] CheckoutPlaceOrderActionGroup");
		$grabOrderNumber = $I->grabTextFrom("div.checkout-success > p:nth-child(1) > span"); // stepKey: grabOrderNumber
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: onOrdersPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearOnOrdersPage
		$I->comment("Entering Action Group [clearGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearGridFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearGridFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->fillField("#fulltext", $grabOrderNumber); // stepKey: fillOrderNum
		$I->click(".//*[@id='container']/div/div[2]/div[1]/div[2]/button"); // stepKey: submitSearchOrderNum
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearOnSearch
		$I->comment("Entering Action Group [clickOrderRow] AdminOrderGridClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickFirstOrderRowClickOrderRow
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageLoadClickOrderRow
		$I->comment("Exiting Action Group [clickOrderRow] AdminOrderGridClickFirstRowActionGroup");
		$I->see("Pending", ".order-information table.order-information-table #order_status"); // stepKey: seeAdminOrderStatus
		$I->see("John Doe", ".order-account-information-table"); // stepKey: seeAdminOrderGuest
		$I->see(msq("CustomerEntityOne") . "test@email.com", ".order-account-information-table"); // stepKey: seeAdminOrderEmail
		$I->see("7700 W Parmer Ln", ".order-billing-address"); // stepKey: seeAdminOrderBillingAddress
		$I->see("7700 W Parmer Ln", ".order-shipping-address"); // stepKey: seeAdminOrderShippingAddress
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), ".edit-order-table"); // stepKey: seeAdminOrderProduct
	}
}
