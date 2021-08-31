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
 * @Title("MAGETWO-92453: Guest Checkout with Enabled Persistent")
 * @Description("Checkout data must be restored after page checkout reload.<h3>Test files</h3>app/code/Magento/Persistent/Test/Mftf/Test/GuestCheckoutWithEnabledPersistentTest.xml<br>")
 * @TestCaseId("MAGETWO-92453")
 * @group persistent
 */
class GuestCheckoutWithEnabledPersistentTestCest
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
		$I->createEntity("enablePersistent", "hook", "PersistentConfigEnabled", [], []); // stepKey: enablePersistent
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->createEntity("setDefaultPersistentState", "hook", "PersistentConfigDefault", [], []); // stepKey: setDefaultPersistentState
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
	 * @Features({"Persistent"})
	 * @Stories({"Guest checkout"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function GuestCheckoutWithEnabledPersistentTest(AcceptanceTester $I)
	{
		$I->comment("Add simple product to cart");
		$I->comment("Entering Action Group [addProductToCart1] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddProductToCart1
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddProductToCart1
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddProductToCart1
		$I->waitForPageLoad(30); // stepKey: addToCartAddProductToCart1WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToCart1
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToCart1
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddProductToCart1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart1
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddProductToCart1
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCart1
		$I->comment("Exiting Action Group [addProductToCart1] AddSimpleProductToCartActionGroup");
		$I->comment("Navigate to checkout");
		$I->comment("Entering Action Group [navigateToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityNavigateToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingNavigateToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartNavigateToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartNavigateToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutNavigateToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutNavigateToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Fill Shipping Address form");
		$I->fillField("#customer-email", msq("CustomerEntityOne") . "test@email.com"); // stepKey: enterEmail
		$I->fillField("input[name=firstname]", "John"); // stepKey: enterFirstName
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: enterLastName
		$I->fillField("input[name='street[0]']", "7700 W Parmer Ln"); // stepKey: enterStreet
		$I->fillField("input[name=city]", "Austin"); // stepKey: enterCity
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegion
		$I->fillField("input[name=postcode]", "78729"); // stepKey: enterPostcode
		$I->fillField("input[name=telephone]", "1234568910"); // stepKey: enterTelephone
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMask
		$I->click(".row:nth-of-type(1) .col-method .radio"); // stepKey: selectFirstShippingMethod
		$I->comment("Check that have the same values after page reload");
		$I->comment("Entering Action Group [amOnCheckoutShippingInfoPage] StorefrontOpenCheckoutPageActionGroup");
		$I->amOnPage("/checkout"); // stepKey: openCheckoutPageAmOnCheckoutShippingInfoPage
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPageLoadedAmOnCheckoutShippingInfoPage
		$I->comment("Exiting Action Group [amOnCheckoutShippingInfoPage] StorefrontOpenCheckoutPageActionGroup");
		$I->seeInField("#customer-email", msq("CustomerEntityOne") . "test@email.com"); // stepKey: seeEmailOnCheckout
		$I->seeInField("input[name=firstname]", "John"); // stepKey: seeFirstnameOnCheckout
		$I->seeInField("input[name=lastname]", "Doe"); // stepKey: seeLastnameOnCheckout
		$I->seeInField("input[name='street[0]']", "7700 W Parmer Ln"); // stepKey: seeStreetOnCheckout
		$I->seeInField("input[name=city]", "Austin"); // stepKey: seeCityOnCheckout
		$I->seeInField("select[name=region_id]", "Texas"); // stepKey: seeStateOnCheckout
		$I->seeInField("input[name=postcode]", "78729"); // stepKey: seePostcodeOnCheckout
		$I->seeInField("input[name=telephone]", "1234568910"); // stepKey: seePhoneOnCheckout
		$I->comment("Click next button to open payment section");
		$I->click("button.button.action.continue.primary"); // stepKey: clickNext
		$I->waitForPageLoad(30); // stepKey: clickNextWaitForPageLoad
		$I->comment("Entering Action Group [guestSelectCheckMoneyOrderPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskGuestSelectCheckMoneyOrderPayment
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGuestSelectCheckMoneyOrderPayment
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodGuestSelectCheckMoneyOrderPayment
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionGuestSelectCheckMoneyOrderPayment
		$I->comment("Exiting Action Group [guestSelectCheckMoneyOrderPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Reload payment section");
		$I->amOnPage("/checkout/#payment"); // stepKey: amOnCheckoutPaymentsPage
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButton2
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButton2WaitForPageLoad
		$I->comment("Check that address block contains correct information");
		$I->see("John", ".payment-method._active div.billing-address-details"); // stepKey: seeBilllingFirstName
		$I->see("Doe", ".payment-method._active div.billing-address-details"); // stepKey: seeBilllingLastName
		$I->see("7700 W Parmer Ln", ".payment-method._active div.billing-address-details"); // stepKey: seeBilllingStreet
		$I->see("Austin", ".payment-method._active div.billing-address-details"); // stepKey: seeBilllingCity
		$I->see("Texas", ".payment-method._active div.billing-address-details"); // stepKey: seeBilllingState
		$I->see("78729", ".payment-method._active div.billing-address-details"); // stepKey: seeBilllingPostcode
		$I->see("1234568910", ".payment-method._active div.billing-address-details"); // stepKey: seeBilllingTelephone
		$I->comment("Check that \"Ship To\" block contains correct information");
		$I->see("John", "//div[@class='ship-to']//div[@class='shipping-information-content']"); // stepKey: seeShipToFirstName
		$I->see("Doe", "//div[@class='ship-to']//div[@class='shipping-information-content']"); // stepKey: seeShipToLastName
		$I->see("7700 W Parmer Ln", "//div[@class='ship-to']//div[@class='shipping-information-content']"); // stepKey: seeShipToStreet
		$I->see("Austin", "//div[@class='ship-to']//div[@class='shipping-information-content']"); // stepKey: seeShipToCity
		$I->see("Texas", "//div[@class='ship-to']//div[@class='shipping-information-content']"); // stepKey: seeShipToState
		$I->see("78729", "//div[@class='ship-to']//div[@class='shipping-information-content']"); // stepKey: seeShipToPostcode
		$I->see("1234568910", "//div[@class='ship-to']//div[@class='shipping-information-content']"); // stepKey: seeShipToTelephone
	}
}
