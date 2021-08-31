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
 * @Title("[NO TESTCASEID]: Enable and Disable Clear Shopping Cart Configuration")
 * @Description("Verify that disabling the clear shopping cart store configuration will remove the clear shopping cart configuration button from the storefront's shopping cart page. Verify that enabling the configuration will add the button to the page and that the button functions as expected<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/ClearShoppingCartEnableDisableConfigurationTest.xml<br>")
 * @group shoppingCart
 */
class ClearShoppingCartEnableDisableConfigurationTestCest
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
		$I->comment("Create simple products and category");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct1", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct1
		$I->createEntity("createProduct2", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct2
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("createProduct2", "hook"); // stepKey: deleteProduct2
		$I->comment("Disable clear shopping cart");
		$disableClearShoppingCart = $I->magentoCLI("config:set checkout/cart/enable_clear_shopping_cart 0", 60); // stepKey: disableClearShoppingCart
		$I->comment($disableClearShoppingCart);
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"Shopping Cart"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function ClearShoppingCartEnableDisableConfigurationTest(AcceptanceTester $I)
	{
		$I->comment("Navigate to sales checkout cart configuration");
		$I->comment("Entering Action Group [openSalesCheckoutCartConfig1] AdminOpenSalesCheckoutConfigPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/checkout/#checkout_cart-link"); // stepKey: openCheckoutConfigPageOpenSalesCheckoutCartConfig1
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutConfigPageLoadOpenSalesCheckoutCartConfig1
		$I->comment("Exiting Action Group [openSalesCheckoutCartConfig1] AdminOpenSalesCheckoutConfigPageActionGroup");
		$I->comment("Enable clear shopping cart button");
		$I->comment("Entering Action Group [enableClearShoppingCartButton] AdminSelectClearShoppingCartConfigurationActionGroup");
		$I->waitForElementVisible("#checkout_cart_enable_clear_shopping_cart_inherit", 30); // stepKey: waitForClearShoppingCartEnabledInheritEnableClearShoppingCartButton
		$I->waitForPageLoad(30); // stepKey: waitForClearShoppingCartEnabledInheritEnableClearShoppingCartButtonWaitForPageLoad
		$I->uncheckOption("#checkout_cart_enable_clear_shopping_cart_inherit"); // stepKey: uncheckUseSystemEnableClearShoppingCartButton
		$I->waitForPageLoad(30); // stepKey: uncheckUseSystemEnableClearShoppingCartButtonWaitForPageLoad
		$I->waitForElementVisible("#checkout_cart_enable_clear_shopping_cart", 30); // stepKey: waitForClearShoppingCartEnabledEnableClearShoppingCartButton
		$I->waitForPageLoad(30); // stepKey: waitForClearShoppingCartEnabledEnableClearShoppingCartButtonWaitForPageLoad
		$I->selectOption("#checkout_cart_enable_clear_shopping_cart", "Yes"); // stepKey: fillClearShoppingCartEnabledEnableClearShoppingCartButton
		$I->waitForPageLoad(30); // stepKey: fillClearShoppingCartEnabledEnableClearShoppingCartButtonWaitForPageLoad
		$I->comment("Exiting Action Group [enableClearShoppingCartButton] AdminSelectClearShoppingCartConfigurationActionGroup");
		$I->comment("Entering Action Group [saveStoreConfiguration1] SaveStoreConfigurationActionGroup");
		$I->comment("saveStoreConfiguration");
		$I->waitForElementVisible("#save", 30); // stepKey: waitForSaveButtonSaveStoreConfiguration1
		$I->waitForPageLoad(30); // stepKey: waitForSaveButtonSaveStoreConfiguration1WaitForPageLoad
		$I->click("#save"); // stepKey: clickSaveButtonSaveStoreConfiguration1
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonSaveStoreConfiguration1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSaveStoreConfiguration1
		$I->comment("Exiting Action Group [saveStoreConfiguration1] SaveStoreConfigurationActionGroup");
		$I->comment("Open product 1 and add to cart");
		$I->comment("Entering Action Group [openProduct1Page1] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenProduct1Page1
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProduct1Page1
		$I->comment("Exiting Action Group [openProduct1Page1] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Entering Action Group [product1AddToCart] StorefrontAddToTheCartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadProduct1AddToCart
		$I->scrollTo("#product-addtocart-button"); // stepKey: scrollToAddToCartButtonProduct1AddToCart
		$I->waitForPageLoad(60); // stepKey: scrollToAddToCartButtonProduct1AddToCartWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: addToCartProduct1AddToCart
		$I->waitForPageLoad(60); // stepKey: addToCartProduct1AddToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadProduct1AddToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageProduct1AddToCart
		$I->comment("Exiting Action Group [product1AddToCart] StorefrontAddToTheCartActionGroup");
		$I->comment("Open product 2 and add to cart");
		$I->comment("Entering Action Group [openProduct2Page] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenProduct2Page
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProduct2Page
		$I->comment("Exiting Action Group [openProduct2Page] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Entering Action Group [product2AddToCart] StorefrontAddToTheCartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadProduct2AddToCart
		$I->scrollTo("#product-addtocart-button"); // stepKey: scrollToAddToCartButtonProduct2AddToCart
		$I->waitForPageLoad(60); // stepKey: scrollToAddToCartButtonProduct2AddToCartWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: addToCartProduct2AddToCart
		$I->waitForPageLoad(60); // stepKey: addToCartProduct2AddToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadProduct2AddToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageProduct2AddToCart
		$I->comment("Exiting Action Group [product2AddToCart] StorefrontAddToTheCartActionGroup");
		$I->comment("Go to shopping cart page");
		$I->comment("Entering Action Group [openShoppingCartPage1] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageOpenShoppingCartPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenShoppingCartPage1
		$I->comment("Exiting Action Group [openShoppingCartPage1] StorefrontCartPageOpenActionGroup");
		$I->comment("Clear shopping cart");
		$I->comment("Entering Action Group [clearShoppingCart] StorefrontClearShoppingCartActionGroup");
		$I->waitForElementVisible("#empty_cart_button", 30); // stepKey: waitForEmptyCartButtonClearShoppingCart
		$I->waitForPageLoad(30); // stepKey: waitForEmptyCartButtonClearShoppingCartWaitForPageLoad
		$I->click("#empty_cart_button"); // stepKey: clickEmptyCartButtonClearShoppingCart
		$I->waitForPageLoad(30); // stepKey: clickEmptyCartButtonClearShoppingCartWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm._show .modal-content", 30); // stepKey: waitForModalMessageClearShoppingCart
		$I->waitForPageLoad(30); // stepKey: waitForModalMessageClearShoppingCartWaitForPageLoad
		$I->waitForText("Are you sure you want to remove all items from your shopping cart?", 30, ".modal-popup.confirm._show .modal-content"); // stepKey: waitForTextModalMessageClearShoppingCart
		$I->waitForPageLoad(30); // stepKey: waitForTextModalMessageClearShoppingCartWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm._show .action-accept", 30); // stepKey: waitForModalConfirmButtonClearShoppingCart
		$I->waitForPageLoad(30); // stepKey: waitForModalConfirmButtonClearShoppingCartWaitForPageLoad
		$I->click(".modal-popup.confirm._show .action-accept"); // stepKey: clickModalConfirmButtonClearShoppingCart
		$I->waitForPageLoad(30); // stepKey: clickModalConfirmButtonClearShoppingCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClearShoppingCart
		$I->seeCurrentUrlEquals(getenv("MAGENTO_BASE_URL") . "checkout/cart"); // stepKey: seeCurrentUrlEqualsCartPageClearShoppingCart
		$I->waitForText("You have no items in your shopping cart.", 30, ".cart-empty>p"); // stepKey: waitForEmptyCartMessageClearShoppingCart
		$I->comment("Exiting Action Group [clearShoppingCart] StorefrontClearShoppingCartActionGroup");
		$I->comment("Entering Action Group [assertMiniCartEmpty] AssertMiniCartEmptyActionGroup");
		$I->dontSeeElement("//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: dontSeeMinicartProductCountAssertMiniCartEmpty
		$I->click("a.showcart"); // stepKey: expandMinicartAssertMiniCartEmpty
		$I->waitForPageLoad(60); // stepKey: expandMinicartAssertMiniCartEmptyWaitForPageLoad
		$I->see("You have no items in your shopping cart.", "#minicart-content-wrapper"); // stepKey: seeEmptyCartMessageAssertMiniCartEmpty
		$I->comment("Exiting Action Group [assertMiniCartEmpty] AssertMiniCartEmptyActionGroup");
		$I->comment("Return to Admin to disable clear shopping cart");
		$I->comment("Entering Action Group [openSalesCheckoutCartConfig2] AdminOpenSalesCheckoutConfigPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/checkout/"); // stepKey: openCheckoutConfigPageOpenSalesCheckoutCartConfig2
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutConfigPageLoadOpenSalesCheckoutCartConfig2
		$I->comment("Exiting Action Group [openSalesCheckoutCartConfig2] AdminOpenSalesCheckoutConfigPageActionGroup");
		$I->comment("Entering Action Group [disableClearShoppingCartButton] AdminSelectClearShoppingCartConfigurationActionGroup");
		$I->waitForElementVisible("#checkout_cart_enable_clear_shopping_cart_inherit", 30); // stepKey: waitForClearShoppingCartEnabledInheritDisableClearShoppingCartButton
		$I->waitForPageLoad(30); // stepKey: waitForClearShoppingCartEnabledInheritDisableClearShoppingCartButtonWaitForPageLoad
		$I->uncheckOption("#checkout_cart_enable_clear_shopping_cart_inherit"); // stepKey: uncheckUseSystemDisableClearShoppingCartButton
		$I->waitForPageLoad(30); // stepKey: uncheckUseSystemDisableClearShoppingCartButtonWaitForPageLoad
		$I->waitForElementVisible("#checkout_cart_enable_clear_shopping_cart", 30); // stepKey: waitForClearShoppingCartEnabledDisableClearShoppingCartButton
		$I->waitForPageLoad(30); // stepKey: waitForClearShoppingCartEnabledDisableClearShoppingCartButtonWaitForPageLoad
		$I->selectOption("#checkout_cart_enable_clear_shopping_cart", "No"); // stepKey: fillClearShoppingCartEnabledDisableClearShoppingCartButton
		$I->waitForPageLoad(30); // stepKey: fillClearShoppingCartEnabledDisableClearShoppingCartButtonWaitForPageLoad
		$I->comment("Exiting Action Group [disableClearShoppingCartButton] AdminSelectClearShoppingCartConfigurationActionGroup");
		$I->comment("Entering Action Group [saveStoreConfiguration2] SaveStoreConfigurationActionGroup");
		$I->comment("saveStoreConfiguration");
		$I->waitForElementVisible("#save", 30); // stepKey: waitForSaveButtonSaveStoreConfiguration2
		$I->waitForPageLoad(30); // stepKey: waitForSaveButtonSaveStoreConfiguration2WaitForPageLoad
		$I->click("#save"); // stepKey: clickSaveButtonSaveStoreConfiguration2
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonSaveStoreConfiguration2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSaveStoreConfiguration2
		$I->comment("Exiting Action Group [saveStoreConfiguration2] SaveStoreConfigurationActionGroup");
		$I->comment("Open product 1 page and add to cart");
		$I->comment("Entering Action Group [openProduct1Page2] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenProduct1Page2
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProduct1Page2
		$I->comment("Exiting Action Group [openProduct1Page2] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Entering Action Group [product1AddToCart2] StorefrontAddToTheCartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadProduct1AddToCart2
		$I->scrollTo("#product-addtocart-button"); // stepKey: scrollToAddToCartButtonProduct1AddToCart2
		$I->waitForPageLoad(60); // stepKey: scrollToAddToCartButtonProduct1AddToCart2WaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: addToCartProduct1AddToCart2
		$I->waitForPageLoad(60); // stepKey: addToCartProduct1AddToCart2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadProduct1AddToCart2
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageProduct1AddToCart2
		$I->comment("Exiting Action Group [product1AddToCart2] StorefrontAddToTheCartActionGroup");
		$I->comment("Go to shopping cart and assert clear shopping cart button is not rendered in UI");
		$I->comment("Entering Action Group [openShoppingCartPage2] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageOpenShoppingCartPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenShoppingCartPage2
		$I->comment("Exiting Action Group [openShoppingCartPage2] StorefrontCartPageOpenActionGroup");
		$I->dontSeeElementInDOM("#empty_cart_button"); // stepKey: dontSeeElementEmptyCartButton
		$I->waitForPageLoad(30); // stepKey: dontSeeElementEmptyCartButtonWaitForPageLoad
	}
}
