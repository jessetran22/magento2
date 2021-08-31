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
 * @Title("MC-16050: Wish List should not include disabled products")
 * @Description("Wish List should not include disabled products and pager should be absent<h3>Test files</h3>app/code/Magento/Wishlist/Test/Mftf/Test/WishListWithDisabledProductTest.xml<br>")
 * @TestCaseId("MC-16050")
 * @group wishlist
 */
class WishListWithDisabledProductTestCest
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
        $this->helperContainer->create("Magento\Tax\Test\Mftf\Helper\TaxHelpers");
        $this->helperContainer->create("Magento\Backend\Test\Mftf\Helper\CurlHelpers");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Logout customer");
		$I->comment("Entering Action Group [logoutStorefront] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutStorefront
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutStorefront
		$I->comment("Exiting Action Group [logoutStorefront] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("BIC workaround");
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
	 * @Stories({"Customer wishlist"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"Wishlist"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function WishListWithDisabledProductTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefrontAccount
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefrontAccount
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginToStorefrontAccount
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginToStorefrontAccount
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefrontAccount
		$I->comment("Exiting Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPage
		$I->comment("Entering Action Group [addProductToWishlist] StorefrontCustomerAddProductToWishlistActionGroup");
		$I->waitForElementVisible("a.action.towishlist", 30); // stepKey: WaitForWishListAddProductToWishlist
		$I->click("a.action.towishlist"); // stepKey: addProductToWishlistClickAddToWishlistAddProductToWishlist
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: addProductToWishlistWaitForSuccessMessageAddProductToWishlist
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test') . " has been added to your Wish List. Click here to continue shopping.", "div.message-success.success.message"); // stepKey: addProductToWishlistSeeProductNameAddedToWishlistAddProductToWishlist
		$I->seeCurrentUrlMatches("~/wishlist_id/\d+/$~"); // stepKey: seeCurrentUrlMatchesAddProductToWishlist
		$I->comment("Exiting Action Group [addProductToWishlist] StorefrontCustomerAddProductToWishlistActionGroup");
		$I->comment("Entering Action Group [checkProductInWishlist] StorefrontCustomerCheckProductInWishlistActionGroup");
		$I->waitForElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]", 30); // stepKey: assertWishlistProductNameCheckProductInWishlist
		$I->see("$" . $I->retrieveEntityField('createProduct', 'price', 'test') . ".00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: AssertWishlistProductPriceCheckProductInWishlist
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: wishlistMoveMouseOverProductCheckProductInWishlist
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]//button[contains(@class, 'action tocart primary')]"); // stepKey: AssertWishlistAddToCartCheckProductInWishlist
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]//img[@class='product-image-photo']"); // stepKey: AssertWishlistProductImageCheckProductInWishlist
		$I->comment("Exiting Action Group [checkProductInWishlist] StorefrontCustomerCheckProductInWishlistActionGroup");
		$I->openNewTab(); // stepKey: openNewTab
		$I->comment("Entering Action Group [loginToAdminArea] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminArea
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminArea
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminArea
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminArea
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminAreaWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminArea
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminArea
		$I->comment("Exiting Action Group [loginToAdminArea] AdminLoginActionGroup");
		$I->comment("Entering Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductGoToProductEditPage
		$I->comment("Exiting Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [disableProduct] AdminSetProductDisabledActionGroup");
		$I->conditionalClick("input[name='product[status]']+label", "input[name='product[status]'][value='1']", true); // stepKey: disableProductDisableProduct
		$I->waitForPageLoad(30); // stepKey: disableProductDisableProductWaitForPageLoad
		$I->seeElement("input[name='product[status]'][value='2']"); // stepKey: assertThatProductSetToDisabledDisableProduct
		$I->waitForPageLoad(30); // stepKey: assertThatProductSetToDisabledDisableProductWaitForPageLoad
		$I->comment("Exiting Action Group [disableProduct] AdminSetProductDisabledActionGroup");
		$I->comment("Entering Action Group [saveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormActionGroup");
		$I->closeTab(); // stepKey: closeSecondTab
		$I->reloadPage(); // stepKey: refreshPage
		$I->comment("Entering Action Group [checkProductIsAbsentInWishlistIsEmpty] StorefrontAssertCustomerWishlistIsEmptyActionGroup");
		$I->dontSeeElement(".toolbar .pager"); // stepKey: checkThatPagerIsAbsentCheckProductIsAbsentInWishlistIsEmpty
		$I->see("You have no items in your wish list.", ".form-wishlist-items .message.info.empty"); // stepKey: checkNoItemsMessageCheckProductIsAbsentInWishlistIsEmpty
		$I->comment("Exiting Action Group [checkProductIsAbsentInWishlistIsEmpty] StorefrontAssertCustomerWishlistIsEmptyActionGroup");
	}
}
