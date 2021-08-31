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
 * @Title("MC-36921: Check error when cart contains virtual product")
 * @Description("Check error when cart contains only virtual product<h3>Test files</h3>app/code/Magento/Multishipping/Test/Mftf/Test/StorefrontCheckoutWithWithVirtualProductTest.xml<br>")
 * @TestCaseId("MC-36921")
 * @group Multishipment
 */
class StorefrontCheckoutWithWithVirtualProductTestCest
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
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("firstProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: firstProduct
		$I->createEntity("virtualProduct", "hook", "VirtualProduct", ["createCategory"], []); // stepKey: virtualProduct
		$I->createEntity("createCustomerWithMultipleAddresses", "hook", "Customer_US_UK_DE", [], []); // stepKey: createCustomerWithMultipleAddresses
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("firstProduct", "hook"); // stepKey: deleteFirstProduct
		$I->deleteEntity("virtualProduct", "hook"); // stepKey: deleteVirtualProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createCustomerWithMultipleAddresses", "hook"); // stepKey: deleteCustomer
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
	 * @Stories({"Multiple Shipping"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckoutWithWithVirtualProductTest(AcceptanceTester $I)
	{
		$I->comment("Login to the Storefront as created customer");
		$I->comment("Entering Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginAsCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginAsCustomer
		$I->fillField("#email", $I->retrieveEntityField('createCustomerWithMultipleAddresses', 'email', 'test')); // stepKey: fillEmailLoginAsCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createCustomerWithMultipleAddresses', 'password', 'test')); // stepKey: fillPasswordLoginAsCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginAsCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginAsCustomer
		$I->comment("Exiting Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->comment("Open the simple product page");
		$I->comment("Entering Action Group [goToFirstProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('firstProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageGoToFirstProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedGoToFirstProductPage
		$I->comment("Exiting Action Group [goToFirstProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Add the simple product to the Shopping Cart");
		$I->comment("Entering Action Group [addFirstProductToCart] AddProductWithQtyToCartFromStorefrontProductPageActionGroup");
		$I->fillField("#qty", "1"); // stepKey: fillProductQuantityAddFirstProductToCart
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddFirstProductToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddFirstProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddFirstProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddFirstProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddFirstProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddFirstProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddFirstProductToCart
		$I->see("You added " . $I->retrieveEntityField('firstProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddFirstProductToCart
		$I->comment("Exiting Action Group [addFirstProductToCart] AddProductWithQtyToCartFromStorefrontProductPageActionGroup");
		$I->comment("Open the virtual product page");
		$I->comment("Entering Action Group [goToVirtualProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('virtualProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageGoToVirtualProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedGoToVirtualProductPage
		$I->comment("Exiting Action Group [goToVirtualProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Add the virtual product to the Shopping Cart");
		$I->comment("Entering Action Group [addVirtualProductToCart] AddProductWithQtyToCartFromStorefrontProductPageActionGroup");
		$I->fillField("#qty", "1"); // stepKey: fillProductQuantityAddVirtualProductToCart
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddVirtualProductToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddVirtualProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddVirtualProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddVirtualProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddVirtualProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddVirtualProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddVirtualProductToCart
		$I->see("You added " . $I->retrieveEntityField('virtualProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddVirtualProductToCart
		$I->comment("Exiting Action Group [addVirtualProductToCart] AddProductWithQtyToCartFromStorefrontProductPageActionGroup");
		$I->comment("Go to Cart");
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
		$I->comment("Check Out with Multiple Addresses");
		$I->comment("Entering Action Group [checkoutWithMultipleAddresses] StorefrontCheckoutWithMultipleAddressesActionGroup");
		$I->click("//span[text()='Check Out with Multiple Addresses']"); // stepKey: clickOnCheckoutWithMultipleAddressesCheckoutWithMultipleAddresses
		$I->waitForPageLoad(30); // stepKey: waitForMultipleAddressPageLoadCheckoutWithMultipleAddresses
		$I->comment("Exiting Action Group [checkoutWithMultipleAddresses] StorefrontCheckoutWithMultipleAddressesActionGroup");
		$I->comment("Remove simple product from cart");
		$I->comment("Entering Action Group [removeFirstProductFromCart] StorefrontRemoveProductOnCheckoutActionGroup");
		$I->click("//a[contains(@title, 'Remove Item')][1]"); // stepKey: removeItemRemoveFirstProductFromCart
		$I->comment("Exiting Action Group [removeFirstProductFromCart] StorefrontRemoveProductOnCheckoutActionGroup");
		$I->comment("Assert error message on checkout");
		$I->comment("Entering Action Group [assertErrorMessage] StorefrontAssertCheckoutErrorMessageActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'message-error')]/div[text()='The current cart does not match multi shipping criteria, please review or contact the store administrator']", 30); // stepKey: assertErrorMessageAssertErrorMessage
		$I->comment("Exiting Action Group [assertErrorMessage] StorefrontAssertCheckoutErrorMessageActionGroup");
	}
}
