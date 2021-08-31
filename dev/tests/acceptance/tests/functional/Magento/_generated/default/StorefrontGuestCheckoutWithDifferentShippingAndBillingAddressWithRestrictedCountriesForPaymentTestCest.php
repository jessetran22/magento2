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
 * @Title("MC-41743: Check payment methods update on checkout payment step")
 * @Description("Check that payment methods will update on checkout payment step after updating customer billing address<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontGuestCheckoutWithDifferentShippingAndBillingAddressWithRestrictedCountriesForPaymentTest.xml<br>")
 * @TestCaseId("MC-41743")
 * @group checkout
 */
class StorefrontGuestCheckoutWithDifferentShippingAndBillingAddressWithRestrictedCountriesForPaymentTestCest
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
		$enableBankTransfer = $I->magentoCLI("config:set payment/banktransfer/active 1", 60); // stepKey: enableBankTransfer
		$I->comment($enableBankTransfer);
		$allowSpecificValue = $I->magentoCLI("config:set payment/checkmo/allowspecific 1", 60); // stepKey: allowSpecificValue
		$I->comment($allowSpecificValue);
		$allowBankTransferOnlyForGB = $I->magentoCLI("config:set payment/checkmo/specificcountry GB", 60); // stepKey: allowBankTransferOnlyForGB
		$I->comment($allowBankTransferOnlyForGB);
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$disableBankTransfer = $I->magentoCLI("config:set payment/banktransfer/active 0", 60); // stepKey: disableBankTransfer
		$I->comment($disableBankTransfer);
		$disallowSpecificValue = $I->magentoCLI("config:set payment/checkmo/allowspecific 0", 60); // stepKey: disallowSpecificValue
		$I->comment($disallowSpecificValue);
		$defaultCountryValue = $I->magentoCLI("config:set payment/checkmo/specificcountry ''", 60); // stepKey: defaultCountryValue
		$I->comment($defaultCountryValue);
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
	 * @Stories({"Check payment methods on checkout"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontGuestCheckoutWithDifferentShippingAndBillingAddressWithRestrictedCountriesForPaymentTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Entering Action Group [fillShippingSectionAsGuest] GuestCheckoutFillingShippingSectionActionGroup");
		$I->waitForElementVisible("input[id*=customer-email]", 30); // stepKey: waitForEmailFieldFillShippingSectionAsGuest
		$I->fillField("input[id*=customer-email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: enterEmailFillShippingSectionAsGuest
		$I->fillField("input[name=firstname]", "John"); // stepKey: enterFirstNameFillShippingSectionAsGuest
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: enterLastNameFillShippingSectionAsGuest
		$I->fillField("input[name='street[0]']", "7700 W Parmer Ln"); // stepKey: enterStreetFillShippingSectionAsGuest
		$I->fillField("input[name=city]", "Austin"); // stepKey: enterCityFillShippingSectionAsGuest
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegionFillShippingSectionAsGuest
		$I->fillField("input[name=postcode]", "78729"); // stepKey: enterPostcodeFillShippingSectionAsGuest
		$I->fillField("input[name=telephone]", "1234568910"); // stepKey: enterTelephoneFillShippingSectionAsGuest
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskFillShippingSectionAsGuest
		$I->waitForElement("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input", 30); // stepKey: waitForShippingMethodFillShippingSectionAsGuest
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., '')]/..//input"); // stepKey: selectShippingMethodFillShippingSectionAsGuest
		$I->waitForElement("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonFillShippingSectionAsGuest
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonFillShippingSectionAsGuestWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextFillShippingSectionAsGuest
		$I->waitForPageLoad(30); // stepKey: clickNextFillShippingSectionAsGuestWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedFillShippingSectionAsGuest
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlFillShippingSectionAsGuest
		$I->comment("Exiting Action Group [fillShippingSectionAsGuest] GuestCheckoutFillingShippingSectionActionGroup");
		$I->dontSee("Check / Money order", ".payment-method-title span"); // stepKey: assertNoCheckMoneyOrderPaymentMethod
		$I->waitForElementVisible("#billing-address-same-as-shipping-banktransfer", 30); // stepKey: waitForBillingAddressNotSameAsShippingCheckbox
		$I->uncheckOption("#billing-address-same-as-shipping-banktransfer"); // stepKey: uncheckSameBillingAndShippingAddress
		$I->conditionalClick("button.action.action-edit-address", ".action-edit-address", true); // stepKey: clickEditBillingAddressButton
		$I->waitForPageLoad(30); // stepKey: clickEditBillingAddressButtonWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForBillingAddressFormLoads
		$I->comment("Fill Billing Address");
		$I->comment("Entering Action Group [fillBillingAddress] StorefrontFillBillingAddressActionGroup");
		$I->fillField(".payment-method._active .billing-address-form input[name='firstname']", "Jane"); // stepKey: enterFirstNameFillBillingAddress
		$I->fillField(".payment-method._active .billing-address-form input[name*='lastname']", "Miller"); // stepKey: enterLastNameFillBillingAddress
		$I->fillField(".payment-method._active .billing-address-form input[name*='street[0]']", "1 London Bridge Street"); // stepKey: enterStreetFillBillingAddress
		$I->fillField(".payment-method._active .billing-address-form input[name*='city']", "London"); // stepKey: enterCityFillBillingAddress
		$I->fillField(".payment-method._active .billing-address-form input[name*='postcode']", "SE12 9GF"); // stepKey: enterPostcodeFillBillingAddress
		$I->selectOption(".payment-method._active .billing-address-form select[name*='country_id']", "GB"); // stepKey: enterCountryFillBillingAddress
		$I->fillField(".payment-method._active .billing-address-form input[name*='telephone']", "44 20 7123 1234"); // stepKey: enterTelephoneFillBillingAddress
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskFillBillingAddress
		$I->comment("Exiting Action Group [fillBillingAddress] StorefrontFillBillingAddressActionGroup");
		$I->click(".payment-method._active .payment-method-billing-address .action.action-update"); // stepKey: clickOnUpdateButton
		$I->waitForPageLoad(30); // stepKey: clickOnUpdateButtonWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskDisappear
		$I->see("Check / Money order", ".payment-method-title span"); // stepKey: sdadasdasdsdaasd
	}
}
