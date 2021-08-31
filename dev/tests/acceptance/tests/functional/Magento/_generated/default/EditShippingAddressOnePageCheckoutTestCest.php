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
 * @Title("MC-14680: Edit Shipping Address on Checkout Page.")
 * @Description("Edit Shipping Address on Checkout Page.<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/EditShippingAddressOnePageCheckoutTest.xml<br>")
 * @TestCaseId("MC-14680")
 * @group shoppingCart
 * @group mtf_migrated
 */
class EditShippingAddressOnePageCheckoutTestCest
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
		$I->createEntity("createProduct", "hook", "simpleProductDefault", ["createCategory"], []); // stepKey: createProduct
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_NY", [], []); // stepKey: createCustomer
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
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
	 * @Stories({"Edit Shipping Address"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function EditShippingAddressOnePageCheckoutTest(AcceptanceTester $I)
	{
		$I->comment("Go to Frontend as Customer");
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
		$I->comment("Add product to cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onCategoryPage
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddSimpleProductToCartActionGroup");
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProductToCart
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success"); // stepKey: assertSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddSimpleProductToCartActionGroup");
		$I->comment("Go to checkout page");
		$I->comment("Entering Action Group [customerGoToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityCustomerGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingCustomerGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartCustomerGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartCustomerGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutCustomerGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutCustomerGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [customerGoToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("*New Address* button on 1st checkout step");
		$I->click(".action-show-popup"); // stepKey: addNewAddress
		$I->waitForPageLoad(30); // stepKey: addNewAddressWaitForPageLoad
		$I->comment("Fill in required fields and click *Save address* button");
		$I->comment("Entering Action Group [changeAddress] FillShippingAddressOneStreetActionGroup");
		$I->fillField("input[name=firstname]", "Jane"); // stepKey: fillFirstNameChangeAddress
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: fillLastNameChangeAddress
		$I->fillField("input[name=company]", "Magento"); // stepKey: fillCompanyChangeAddress
		$I->fillField("input[name=telephone]", "444-44-444-44"); // stepKey: fillPhoneNumberChangeAddress
		$I->fillField("input[name='street[0]']", "172, Westminster Bridge Rd"); // stepKey: fillStreetAddressChangeAddress
		$I->fillField("input[name=city]", "London"); // stepKey: fillCityNameChangeAddress
		$I->selectOption("select[name=country_id]", "GB"); // stepKey: selectCountyChangeAddress
		$I->fillField("input[name=postcode]", "SE1 7RW"); // stepKey: fillZipChangeAddress
		$I->comment("Exiting Action Group [changeAddress] FillShippingAddressOneStreetActionGroup");
		$I->comment("Entering Action Group [saveNewAddress] StorefrontCheckoutClickSaveAddressButtonActionGroup");
		$I->waitForElementVisible(".action-save-address", 30); // stepKey: waitForSaveButtonSaveNewAddress
		$I->click(".action-save-address"); // stepKey: clickSaveButtonSaveNewAddress
		$I->waitForPageLoad(30); // stepKey: waitForAddressSavedSaveNewAddress
		$I->waitForElementNotVisible("#co-shipping-form", 30); // stepKey: waitForNewAddressFormGoneSaveNewAddress
		$I->comment("Exiting Action Group [saveNewAddress] StorefrontCheckoutClickSaveAddressButtonActionGroup");
		$I->comment("Select Shipping Rate");
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToShippingRate
		$I->waitForPageLoad(30); // stepKey: scrollToShippingRateWaitForPageLoad
		$I->click("#checkout-shipping-method-load input[value='flatrate_flatrate']"); // stepKey: selectShippingMethod
		$I->comment("Click *Edit* button for the new address");
		$I->click("//div[@class='shipping-address-item selected-item']//span[text()='Edit']"); // stepKey: editNewAddress
		$I->waitForPageLoad(30); // stepKey: editNewAddressWaitForPageLoad
		$I->comment("Remove values from required fields and click *Cancel* button");
		$I->comment("Entering Action Group [clearRequiredFields] ClearShippingAddressActionGroup");
		$I->clearField("input[name=firstname]"); // stepKey: clearFieldFirstNameClearRequiredFields
		$I->clearField("input[name=company]"); // stepKey: clearFieldCompanyClearRequiredFields
		$I->clearField("input[name='street[0]']"); // stepKey: clearFieldStreetAddressClearRequiredFields
		$I->clearField("input[name=city]"); // stepKey: clearFieldCityNameClearRequiredFields
		$I->selectOption("select[name=region_id]", ""); // stepKey: clearFieldRegionClearRequiredFields
		$I->clearField("input[name=postcode]"); // stepKey: clearFieldZipClearRequiredFields
		$I->selectOption("select[name=country_id]", ""); // stepKey: clearFieldCountyClearRequiredFields
		$I->clearField("input[name=telephone]"); // stepKey: clearFieldPhoneNumberClearRequiredFields
		$I->comment("Exiting Action Group [clearRequiredFields] ClearShippingAddressActionGroup");
		$I->click(".action-hide-popup"); // stepKey: cancelEditAddress
		$I->comment("Go to *Next*");
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToButtonNext
		$I->waitForPageLoad(30); // stepKey: scrollToButtonNextWaitForPageLoad
		$I->comment("Entering Action Group [goNext] StorefrontCheckoutClickNextButtonActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGoNext
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGoNextWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickOnNextButtonGoNext
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonGoNextWaitForPageLoad
		$I->comment("Exiting Action Group [goNext] StorefrontCheckoutClickNextButtonActionGroup");
		$I->comment("Select payment solution");
		$I->checkOption("#billing-address-same-as-shipping-checkmo"); // stepKey: selectPaymentSolution
		$I->comment("Refresh Page and Place Order");
		$I->reloadPage(); // stepKey: reloadPage
		$I->comment("Entering Action Group [placeOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPagePlaceOrder
		$I->comment("Exiting Action Group [placeOrder] ClickPlaceOrderActionGroup");
	}
}
