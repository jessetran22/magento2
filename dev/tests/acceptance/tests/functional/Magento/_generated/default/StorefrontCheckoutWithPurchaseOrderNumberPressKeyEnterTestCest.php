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
 * @Title("MC-37227: Create Checkout with purchase order payment method test. Press key Enter on field Purchase Order Number for create Order.")
 * @Description("Create Checkout with purchase order payment method. Press key Enter on field Purchase Order Number for create Order.<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontCheckoutWithPurchaseOrderNumberPressKeyEnterTest.xml<br>")
 * @TestCaseId("MC-37227")
 * @group checkout
 */
class StorefrontCheckoutWithPurchaseOrderNumberPressKeyEnterTestCest
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
		$I->createEntity("createSimpleProduct", "hook", "SimpleTwo", [], []); // stepKey: createSimpleProduct
		$I->comment("Enable payment method");
		$enablePaymentMethod = $I->magentoCLI("config:set payment/purchaseorder/active 1", 60); // stepKey: enablePaymentMethod
		$I->comment($enablePaymentMethod);
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
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Disable payment method");
		$disablePaymentMethod = $I->magentoCLI("config:set payment/purchaseorder/active 0", 60); // stepKey: disablePaymentMethod
		$I->comment($disablePaymentMethod);
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
	 * @Stories({"Checkout with Purchase Order Payment. Create Order with Press Key Enter."})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckoutWithPurchaseOrderNumberPressKeyEnterTest(AcceptanceTester $I)
	{
		$I->comment("Go to product page");
		$I->amOnPage($I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToSimpleProductPage
		$I->waitForPageLoad(30); // stepKey: waitForCatalogPageLoad
		$I->comment("Add Product to Shopping Cart");
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Go to Checkout");
		$I->comment("Entering Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
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
		$I->comment("Checkout select Purchase Order payment");
		$I->comment("Entering Action Group [selectPurchaseOrderPayment] CheckoutSelectPurchaseOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectPurchaseOrderPayment
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectPurchaseOrderPayment
		$I->conditionalClick("input#purchaseorder.radio", "input#purchaseorder.radio", true); // stepKey: checkPurchaseOrderOptionSelectPurchaseOrderPayment
		$I->waitForPageLoad(30); // stepKey: checkPurchaseOrderOptionSelectPurchaseOrderPaymentWaitForPageLoad
		$I->fillField("#po_number", "12345"); // stepKey: fillPurchaseOrderNumberSelectPurchaseOrderPayment
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectPurchaseOrderPayment
		$I->comment("Exiting Action Group [selectPurchaseOrderPayment] CheckoutSelectPurchaseOrderPaymentActionGroup");
		$I->comment("Press Key ENTER");
		$I->pressKey("#po_number", \Facebook\WebDriver\WebDriverKeys::ENTER); // stepKey: pressKeyEnter
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->comment("See success messages");
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: seeSuccessTitle
		$I->see("Your order # is: ", ".checkout-success > p:nth-child(1)"); // stepKey: seeOrderNumber
	}
}
