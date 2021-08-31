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
 * @Title("[NO TESTCASEID]: Billing Address empty after going back and forth between shipping and payment step")
 * @Description("Check billing address editing cancelation during checkout on the payment step<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/OnePageCheckoutCancelEditingBillingAddress.xml<br>")
 * @group checkout
 */
class OnePageCheckoutCancelEditingBillingAddressCest
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
		$I->comment("Create Simple Product");
		$createSimpleProductFields['price'] = "160";
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], $createSimpleProductFields); // stepKey: createSimpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created product");
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
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
	 * @Stories({"MC-39581: Billing Address empty after going back and forth between shipping and payment step"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function OnePageCheckoutCancelEditingBillingAddress(AcceptanceTester $I)
	{
		$I->comment("Add Simple Product to cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToSimpleProductPage
		$I->waitForPageLoad(30); // stepKey: waitForSimpleProductPageLoad
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
		$I->comment("Navigate to checkout");
		$I->comment("Entering Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Fill shipping address");
		$I->comment("Entering Action Group [guestCheckoutFillingShipping] GuestCheckoutFillingShippingSectionActionGroup");
		$I->waitForElementVisible("input[id*=customer-email]", 30); // stepKey: waitForEmailFieldGuestCheckoutFillingShipping
		$I->fillField("input[id*=customer-email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: enterEmailGuestCheckoutFillingShipping
		$I->fillField("input[name=firstname]", "John"); // stepKey: enterFirstNameGuestCheckoutFillingShipping
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: enterLastNameGuestCheckoutFillingShipping
		$I->fillField("input[name='street[0]']", "7700 W Parmer Ln"); // stepKey: enterStreetGuestCheckoutFillingShipping
		$I->fillField("input[name=city]", "Austin"); // stepKey: enterCityGuestCheckoutFillingShipping
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegionGuestCheckoutFillingShipping
		$I->fillField("input[name=postcode]", "78729"); // stepKey: enterPostcodeGuestCheckoutFillingShipping
		$I->fillField("input[name=telephone]", "1234568910"); // stepKey: enterTelephoneGuestCheckoutFillingShipping
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskGuestCheckoutFillingShipping
		$I->waitForElement("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", 30); // stepKey: waitForShippingMethodGuestCheckoutFillingShipping
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input"); // stepKey: selectShippingMethodGuestCheckoutFillingShipping
		$I->waitForElement("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGuestCheckoutFillingShipping
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGuestCheckoutFillingShippingWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGuestCheckoutFillingShipping
		$I->waitForPageLoad(30); // stepKey: clickNextGuestCheckoutFillingShippingWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedGuestCheckoutFillingShipping
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlGuestCheckoutFillingShipping
		$I->comment("Exiting Action Group [guestCheckoutFillingShipping] GuestCheckoutFillingShippingSectionActionGroup");
		$I->comment("Change the address");
		$I->waitForElementVisible("#billing-address-same-as-shipping-checkmo", 30); // stepKey: waitForElementToBeVisible
		$I->uncheckOption("#billing-address-same-as-shipping-checkmo"); // stepKey: uncheckSameBillingAndShippingAddress
		$I->conditionalClick("//div[contains(@class,'payment-method _active')]//button[contains(@class,'action action-edit-address')]", "//div[contains(@class,'payment-method _active')]//button[contains(@class,'action action-edit-address')]", true); // stepKey: clickEditButton
		$I->waitForPageLoad(30); // stepKey: clickEditButtonWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMask
		$I->comment("Fill in New Billing Address");
		$I->comment("Entering Action Group [fillBillingAddress] StorefrontFillBillingAddressActionGroup");
		$I->fillField(".payment-method._active .billing-address-form input[name='firstname']", "John"); // stepKey: enterFirstNameFillBillingAddress
		$I->fillField(".payment-method._active .billing-address-form input[name*='lastname']", "Doe"); // stepKey: enterLastNameFillBillingAddress
		$I->fillField(".payment-method._active .billing-address-form input[name*='street[0]']", "7700 West Parmer Lane"); // stepKey: enterStreetFillBillingAddress
		$I->fillField(".payment-method._active .billing-address-form input[name*='city']", "Los Angeles"); // stepKey: enterCityFillBillingAddress
		$I->fillField(".payment-method._active .billing-address-form input[name*='postcode']", "90001"); // stepKey: enterPostcodeFillBillingAddress
		$I->selectOption(".payment-method._active .billing-address-form select[name*='country_id']", "US"); // stepKey: enterCountryFillBillingAddress
		$I->fillField(".payment-method._active .billing-address-form input[name*='telephone']", "512-345-6789"); // stepKey: enterTelephoneFillBillingAddress
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskFillBillingAddress
		$I->comment("Exiting Action Group [fillBillingAddress] StorefrontFillBillingAddressActionGroup");
		$I->selectOption(".payment-method._active .billing-address-form select[name*='region_id']", "California"); // stepKey: selectRegion
		$I->click(".payment-method._active .payment-method-billing-address .action.action-update"); // stepKey: clickOnUpdateButton
		$I->waitForPageLoad(30); // stepKey: clickOnUpdateButtonWaitForPageLoad
		$I->comment("Edit Billing Address");
		$I->waitForElementVisible(".action-edit-address", 30); // stepKey: waitForEditBillingAddressButton
		$I->waitForPageLoad(30); // stepKey: waitForEditBillingAddressButtonWaitForPageLoad
		$I->click(".action-edit-address"); // stepKey: clickOnEditButton
		$I->waitForPageLoad(30); // stepKey: clickOnEditButtonWaitForPageLoad
		$I->fillField(".payment-method._active .billing-address-form input[name='firstname']", ""); // stepKey: enterEmptyFirstName
		$I->fillField(".payment-method._active .billing-address-form input[name*='lastname']", ""); // stepKey: enterEmptyLastName
		$I->comment("Cancel Editing Billing Address");
		$I->click(".opc-progress-bar-item:nth-of-type(1)"); // stepKey: goToShipping
		$I->waitForPageLoad(30); // stepKey: goToShippingWaitForPageLoad
		$I->comment("Entering Action Group [clickOnNextButton] StorefrontCheckoutClickNextButtonActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickOnNextButton
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickOnNextButtonWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickOnNextButtonClickOnNextButton
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonClickOnNextButtonWaitForPageLoad
		$I->comment("Exiting Action Group [clickOnNextButton] StorefrontCheckoutClickNextButtonActionGroup");
		$I->comment("Place order");
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoaded
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderButton
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderButtonWaitForPageLoad
		$I->seeElement("div.checkout-success"); // stepKey: orderIsSuccessfullyPlaced
	}
}
