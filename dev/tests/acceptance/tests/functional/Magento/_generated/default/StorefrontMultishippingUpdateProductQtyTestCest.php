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
 * @Title("MC-41697: Update Product Quantity on Ship to Multiple Addresses Page.")
 * @Description("Verify customer will see correct product quantity after return to Ship to Multiple Addresses from Shipping information page.<h3>Test files</h3>app/code/Magento/Multishipping/Test/Mftf/Test/StorefrontMultishippingUpdateProductQtyTest.xml<br>")
 * @TestCaseId("MC-41697")
 * @group multishipping
 */
class StorefrontMultishippingUpdateProductQtyTestCest
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
		$I->createEntity("product", "hook", "SimpleProduct2", [], []); // stepKey: product
		$I->createEntity("customer", "hook", "Simple_US_CA_Customer", [], []); // stepKey: customer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("product", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogout
		$I->comment("Exiting Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Features({"Multishipping"})
	 * @Stories({"Checkout with multiple addresses."})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontMultishippingUpdateProductQtyTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefrontAccount
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefrontAccount
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailLoginToStorefrontAccount
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test')); // stepKey: fillPasswordLoginToStorefrontAccount
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefrontAccount
		$I->comment("Exiting Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [navigateToSimpleProductDetailsPage] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('product', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageNavigateToSimpleProductDetailsPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedNavigateToSimpleProductDetailsPage
		$I->comment("Exiting Action Group [navigateToSimpleProductDetailsPage] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Entering Action Group [addSimpleProductToCart] StorefrontAddProductToCartWithQtyActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadAddSimpleProductToCart
		$I->fillField("input.input-text.qty", "2"); // stepKey: fillProduct1QuantityAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: fillProduct1QuantityAddSimpleProductToCartWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToCartButtonAddSimpleProductToCart
		$I->waitForPageLoad(60); // stepKey: clickOnAddToCartButtonAddSimpleProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToAddInCartAddSimpleProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddSimpleProductToCart
		$I->seeElement("div.message-success"); // stepKey: seeSuccessSaveMessageAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: seeSuccessSaveMessageAddSimpleProductToCartWaitForPageLoad
		$I->comment("Exiting Action Group [addSimpleProductToCart] StorefrontAddProductToCartWithQtyActionGroup");
		$I->comment("Entering Action Group [openCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageOpenCart
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartOpenCart
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartOpenCartWaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkOpenCart
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkOpenCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartOpenCart
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartOpenCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartOpenCart
		$I->waitForPageLoad(30); // stepKey: clickCartOpenCartWaitForPageLoad
		$I->comment("Exiting Action Group [openCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->comment("Entering Action Group [checkoutWithMultipleAddresses] StorefrontCheckoutWithMultipleAddressesActionGroup");
		$I->click("//span[text()='Check Out with Multiple Addresses']"); // stepKey: clickOnCheckoutWithMultipleAddressesCheckoutWithMultipleAddresses
		$I->waitForPageLoad(30); // stepKey: waitForMultipleAddressPageLoadCheckoutWithMultipleAddresses
		$I->comment("Exiting Action Group [checkoutWithMultipleAddresses] StorefrontCheckoutWithMultipleAddressesActionGroup");
		$I->comment("Entering Action Group [setProductQuantity] StorefrontChangeMultishippingItemQtyActionGroup");
		$I->fillField("#multiship-addresses-table tbody tr:nth-of-type(1) .col.qty input", "2"); // stepKey: setQuantitySetProductQuantity
		$I->comment("Exiting Action Group [setProductQuantity] StorefrontChangeMultishippingItemQtyActionGroup");
		$I->comment("Entering Action Group [navigateToShippingInformation] StorefrontNavigateToShippingInformationPageActionGroup");
		$I->waitForElementVisible("//span[text()='Go to Shipping Information']", 30); // stepKey: waitForButtonNavigateToShippingInformation
		$I->click("//span[text()='Go to Shipping Information']"); // stepKey: goToShippingInformationNavigateToShippingInformation
		$I->waitForPageLoad(30); // stepKey: waitForShippingInfoPageNavigateToShippingInformation
		$I->comment("Exiting Action Group [navigateToShippingInformation] StorefrontNavigateToShippingInformationPageActionGroup");
		$I->moveBack(); // stepKey: moveBackToShippingInformation
		$I->comment("Entering Action Group [verifyLine1Qty] AssertStorefrontMultishippingAddressAndItemActionGroup");
		$I->seeElement("(//form[@id='checkout_multishipping_form']//a[contains(text(),'" . $I->retrieveEntityField('product', 'name', 'test') . "')])[1]"); // stepKey: verifyProductNameVerifyLine1Qty
		$I->seeInField("#multiship-addresses-table tbody tr:nth-of-type(1) .col.qty input", "1"); // stepKey: verifyQuantityVerifyLine1Qty
		$I->seeInField("//tr[position()=1]//td[@data-th='Send To']//select", "John Doe, 7700 West Parmer Lane 113, Los Angeles, California 90001, United States"); // stepKey: verifyAddressVerifyLine1Qty
		$I->comment("Exiting Action Group [verifyLine1Qty] AssertStorefrontMultishippingAddressAndItemActionGroup");
		$I->comment("Entering Action Group [verifyLine2Qty] AssertStorefrontMultishippingAddressAndItemActionGroup");
		$I->seeElement("(//form[@id='checkout_multishipping_form']//a[contains(text(),'" . $I->retrieveEntityField('product', 'name', 'test') . "')])[2]"); // stepKey: verifyProductNameVerifyLine2Qty
		$I->seeInField("#multiship-addresses-table tbody tr:nth-of-type(2) .col.qty input", "1"); // stepKey: verifyQuantityVerifyLine2Qty
		$I->seeInField("//tr[position()=2]//td[@data-th='Send To']//select", "John Doe, 7700 West Parmer Lane 113, Los Angeles, California 90001, United States"); // stepKey: verifyAddressVerifyLine2Qty
		$I->comment("Exiting Action Group [verifyLine2Qty] AssertStorefrontMultishippingAddressAndItemActionGroup");
		$I->comment("Entering Action Group [verifyLine3Qty] AssertStorefrontMultishippingAddressAndItemActionGroup");
		$I->seeElement("(//form[@id='checkout_multishipping_form']//a[contains(text(),'" . $I->retrieveEntityField('product', 'name', 'test') . "')])[3]"); // stepKey: verifyProductNameVerifyLine3Qty
		$I->seeInField("#multiship-addresses-table tbody tr:nth-of-type(3) .col.qty input", "1"); // stepKey: verifyQuantityVerifyLine3Qty
		$I->seeInField("//tr[position()=3]//td[@data-th='Send To']//select", "John Doe, 7700 West Parmer Lane 113, Los Angeles, California 90001, United States"); // stepKey: verifyAddressVerifyLine3Qty
		$I->comment("Exiting Action Group [verifyLine3Qty] AssertStorefrontMultishippingAddressAndItemActionGroup");
	}
}
