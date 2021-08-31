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
 * @Title("MC-38994: Check subtotals after products quantity updated")
 * @Description("Check cart subtotals updates after product quantity updates<h3>Test files</h3>app/code/Magento/Multishipping/Test/Mftf/Test/StorefrontCheckoutSubtotalAfterQuantityUpdateTest.xml<br>")
 * @TestCaseId("MC-38994")
 * @group Multishipment
 */
class StorefrontCheckoutSubtotalAfterQuantityUpdateTestCest
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
		$I->createEntity("createdSimpleProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createdSimpleProduct
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
		$I->deleteEntity("createdSimpleProduct", "hook"); // stepKey: deleteCreatedSimpleProduct
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
	public function StorefrontCheckoutSubtotalAfterQuantityUpdateTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [goToCreatedSimpleProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createdSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageGoToCreatedSimpleProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedGoToCreatedSimpleProductPage
		$I->comment("Exiting Action Group [goToCreatedSimpleProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Add the simple product to the Shopping Cart");
		$I->comment("Entering Action Group [addCreatedSimpleProductToCart] AddProductWithQtyToCartFromStorefrontProductPageActionGroup");
		$I->fillField("#qty", "1"); // stepKey: fillProductQuantityAddCreatedSimpleProductToCart
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddCreatedSimpleProductToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddCreatedSimpleProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddCreatedSimpleProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddCreatedSimpleProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddCreatedSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddCreatedSimpleProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddCreatedSimpleProductToCart
		$I->see("You added " . $I->retrieveEntityField('createdSimpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddCreatedSimpleProductToCart
		$I->comment("Exiting Action Group [addCreatedSimpleProductToCart] AddProductWithQtyToCartFromStorefrontProductPageActionGroup");
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
		$I->comment("Go back to the cart");
		$I->click(".action.back"); // stepKey: backToCart
		$I->comment("Update products quantity");
		$I->fillField("//input[@data-cart-item-id='" . $I->retrieveEntityField('createdSimpleProduct', 'sku', 'test') . "'][@title='Qty']", "2"); // stepKey: updateProductQty
		$I->click("#form-validate button[type='submit'].update"); // stepKey: clickUpdateShoppingCart
		$I->waitForPageLoad(30); // stepKey: clickUpdateShoppingCartWaitForPageLoad
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxLoad
		$I->comment("Check subtotals");
		$grabTextFromProductsSubtotalField = $I->grabTextFrom("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createdSimpleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'subtotal')]//span[@class='price']"); // stepKey: grabTextFromProductsSubtotalField
		$grabTextFromCartSubtotalField = $I->grabTextFrom("span[data-th='Subtotal']"); // stepKey: grabTextFromCartSubtotalField
		$I->assertEquals($grabTextFromProductsSubtotalField, $grabTextFromCartSubtotalField, "Subtotals should be equal"); // stepKey: assertSubtotalsFields
	}
}
