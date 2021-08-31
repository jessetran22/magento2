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
 * @Title("MC-36299: Remove product added to shopping cart")
 * @Description("The product has to be deleted from shopping cart if it deleted in admin panel<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontCheckIsCartUpdatedAfterProductDeleteTest.xml<br>")
 * @TestCaseId("MC-36299")
 * @group checkout
 * @group catalog
 */
class StorefrontCheckIsCartUpdatedAfterProductDeleteTestCest
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
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$createFirstProductFields['price'] = "10.00";
		$I->createEntity("createFirstProduct", "hook", "SimpleProduct2", [], $createFirstProductFields); // stepKey: createFirstProduct
		$createSecondProductFields['price'] = "20.00";
		$I->createEntity("createSecondProduct", "hook", "SimpleProduct2", [], $createSecondProductFields); // stepKey: createSecondProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomer
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomer
		$I->comment("Exiting Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createSecondProduct", "hook"); // stepKey: deleteSecondProduct
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
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
	 * @Features({"Checkout"})
	 * @Stories({"Delete Products from Shopping Cart"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckIsCartUpdatedAfterProductDeleteTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginToStorefront] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefront
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefront
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefront
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginToStorefront
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginToStorefront
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefront
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefront
		$I->comment("Exiting Action Group [loginToStorefront] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [addFirstProductToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createFirstProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddFirstProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddFirstProductToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddFirstProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartAddFirstProductToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddFirstProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddFirstProductToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddFirstProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddFirstProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddFirstProductToCart
		$I->see("You added " . $I->retrieveEntityField('createFirstProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddFirstProductToCart
		$I->comment("Exiting Action Group [addFirstProductToCart] AddSimpleProductToCartActionGroup");
		$I->comment("Entering Action Group [addSecondProductToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSecondProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddSecondProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddSecondProductToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddSecondProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartAddSecondProductToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddSecondProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddSecondProductToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddSecondProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSecondProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddSecondProductToCart
		$I->see("You added " . $I->retrieveEntityField('createSecondProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddSecondProductToCart
		$I->comment("Exiting Action Group [addSecondProductToCart] AddSimpleProductToCartActionGroup");
		$I->comment("Entering Action Group [selectViewAndEditCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartSelectViewAndEditCart
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartSelectViewAndEditCartWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartSelectViewAndEditCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleSelectViewAndEditCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleSelectViewAndEditCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartSelectViewAndEditCart
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartSelectViewAndEditCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSelectViewAndEditCart
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlSelectViewAndEditCart
		$I->comment("Exiting Action Group [selectViewAndEditCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->comment("Entering Action Group [assertCartTotals] AssertStorefrontShoppingCartSummaryItemsActionGroup");
		$I->seeInCurrentUrl("/checkout/cart"); // stepKey: assertUrlAssertCartTotals
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']", 30); // stepKey: waitForSubtotalVisibleAssertCartTotals
		$I->see("$30.00", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: assertSubtotalAssertCartTotals
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']", 30); // stepKey: waitForTotalVisibleAssertCartTotals
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price' and contains(text(), '.00')]", 30); // stepKey: waitForTotalAmountVisibleAssertCartTotals
		$I->see("$40.00", "//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']"); // stepKey: assertTotalAssertCartTotals
		$I->seeElement(".action.primary.checkout span"); // stepKey: seeProceedToCheckoutButtonAssertCartTotals
		$I->waitForPageLoad(30); // stepKey: seeProceedToCheckoutButtonAssertCartTotalsWaitForPageLoad
		$I->comment("Exiting Action Group [assertCartTotals] AssertStorefrontShoppingCartSummaryItemsActionGroup");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [deleteFirstProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteFirstProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteFirstProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteFirstProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteFirstProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createFirstProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterDeleteFirstProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteFirstProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteFirstProductWaitForPageLoad
		$I->see($I->retrieveEntityField('createFirstProduct', 'sku', 'test'), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteFirstProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteFirstProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteFirstProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteFirstProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteFirstProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteFirstProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteFirstProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteFirstProduct
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteFirstProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteFirstProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteFirstProductWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteFirstProduct
		$I->comment("Exiting Action Group [deleteFirstProduct] DeleteProductBySkuActionGroup");
		$I->comment("Entering Action Group [goToShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToShoppingCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToShoppingCartPage
		$I->comment("Exiting Action Group [goToShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [assertCartAfterProductDeleted] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->waitForElementVisible("//tbody[@class='cart item']//strong[@class='product-item-name']", 60); // stepKey: waitForProductNameVisibleAssertCartAfterProductDeleted
		$I->see($I->retrieveEntityField('createSecondProduct', 'name', 'test'), "//tbody[@class='cart item']//strong[@class='product-item-name']"); // stepKey: seeProductNameInCheckoutSummaryAssertCartAfterProductDeleted
		$I->see($I->retrieveEntityField('createSecondProduct', 'price', 'test'), "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSecondProduct', 'name', 'test') . "'][1]//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: seeProductPriceInCartAssertCartAfterProductDeleted
		$I->see($I->retrieveEntityField('createSecondProduct', 'price', 'test'), "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSecondProduct', 'name', 'test') . "'][1]//td[contains(@class, 'subtotal')]//span[@class='price']"); // stepKey: seeSubtotalPriceAssertCartAfterProductDeleted
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSecondProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "1"); // stepKey: seeProductQuantityAssertCartAfterProductDeleted
		$I->comment("Exiting Action Group [assertCartAfterProductDeleted] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->dontSee($I->retrieveEntityField('createFirstProduct', 'name', 'test'), "//tbody[@class='cart item']//strong[@class='product-item-name']"); // stepKey: checkFirstProductIsAbsentInCart
	}
}
