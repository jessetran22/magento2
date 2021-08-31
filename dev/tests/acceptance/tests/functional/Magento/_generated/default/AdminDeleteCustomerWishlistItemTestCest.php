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
 * @Title("MC-35170: Admin deletes an item from customer wishlist")
 * @Description("Admin Should be able delete items from customer wishlist<h3>Test files</h3>app/code/Magento/Wishlist/Test/Mftf/Test/AdminDeleteCustomerWishListItemTest.xml<br>")
 * @TestCaseId("MC-35170")
 * @group wishlist
 */
class AdminDeleteCustomerWishlistItemTestCest
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
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomer
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomer
		$I->comment("Exiting Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
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
	 * @Features({"Wishlist"})
	 * @Stories({"Wishlist items deleting"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteCustomerWishlistItemTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [openProductFromCategory] OpenProductFromCategoryPageActionGroup");
		$I->comment("Go to storefront category page");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_path]', 'test') . ".html"); // stepKey: navigateToCategoryPageOpenProductFromCategory
		$I->comment("Go to storefront product page");
		$I->click("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]"); // stepKey: openProductPageOpenProductFromCategory
		$I->waitForAjaxLoad(30); // stepKey: waitForImageLoaderOpenProductFromCategory
		$I->comment("Exiting Action Group [openProductFromCategory] OpenProductFromCategoryPageActionGroup");
		$I->comment("Entering Action Group [addToWishlistProduct] StorefrontCustomerAddProductToWishlistActionGroup");
		$I->waitForElementVisible("a.action.towishlist", 30); // stepKey: WaitForWishListAddToWishlistProduct
		$I->click("a.action.towishlist"); // stepKey: addProductToWishlistClickAddToWishlistAddToWishlistProduct
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: addProductToWishlistWaitForSuccessMessageAddToWishlistProduct
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test') . " has been added to your Wish List. Click here to continue shopping.", "div.message-success.success.message"); // stepKey: addProductToWishlistSeeProductNameAddedToWishlistAddToWishlistProduct
		$I->seeCurrentUrlMatches("~/wishlist_id/\d+/$~"); // stepKey: seeCurrentUrlMatchesAddToWishlistProduct
		$I->comment("Exiting Action Group [addToWishlistProduct] StorefrontCustomerAddProductToWishlistActionGroup");
		$I->comment("Entering Action Group [logout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogout
		$I->comment("Exiting Action Group [logout] StorefrontCustomerLogoutActionGroup");
		$I->comment("Entering Action Group [adminLogoutBeforeCheck] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogoutBeforeCheck
		$I->comment("Exiting Action Group [adminLogoutBeforeCheck] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [navigateToCustomerEditPage] OpenEditCustomerFromAdminActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersNavigateToCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCustomerEditPage
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersNavigateToCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersNavigateToCustomerEditPageWaitForPageLoad
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFilterNavigateToCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: openFilterNavigateToCustomerEditPageWaitForPageLoad
		$I->fillField("input[name=email]", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailNavigateToCustomerEditPage
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterNavigateToCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: applyFilterNavigateToCustomerEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCustomerEditPage
		$I->click("tr[data-repeat-index='0'] .action-menu-item"); // stepKey: clickEditNavigateToCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: clickEditNavigateToCustomerEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCustomerEditPage
		$I->comment("Exiting Action Group [navigateToCustomerEditPage] OpenEditCustomerFromAdminActionGroup");
		$I->comment("Entering Action Group [navigateToWishlistTab] AdminNavigateCustomerWishlistTabActionGroup");
		$I->click("#tab_wishlist_content"); // stepKey: clickWishlistButtonNavigateToWishlistTab
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToWishlistTab
		$I->comment("Exiting Action Group [navigateToWishlistTab] AdminNavigateCustomerWishlistTabActionGroup");
		$I->comment("Entering Action Group [findWishlistItem] AdminCustomerFindWishlistItemActionGroup");
		$I->fillField("#wishlistGrid_filter_product_name", $I->retrieveEntityField('createProduct', 'name', 'test')); // stepKey: fillProductNameFieldFindWishlistItem
		$I->click("#wishlistGrid button[data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFindWishlistItem
		$I->waitForAjaxLoad(60); // stepKey: waitForLoadingFindWishlistItem
		$I->comment("Exiting Action Group [findWishlistItem] AdminCustomerFindWishlistItemActionGroup");
		$I->comment("Entering Action Group [deleteItem] AdminCustomerDeleteWishlistItemActionGroup");
		$I->click("//*[@id='wishlistGrid_table']//*[@data-column='action']//*[text()='Delete']"); // stepKey: clickDeleteButtonDeleteItem
		$I->waitForPageLoad(30); // stepKey: waitForResultsLoadingDeleteItem
		$I->click(".modal-popup.confirm .action-primary.action-accept"); // stepKey: confirmDeletingDeleteItem
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadingDeleteItem
		$I->comment("Exiting Action Group [deleteItem] AdminCustomerDeleteWishlistItemActionGroup");
		$I->comment("Entering Action Group [assertNoItems] AssertAdminCustomerNoItemsInWishlistActionGroup");
		$I->see("No Items Found", "#wishlistGrid_table"); // stepKey: assertNoItemsAssertNoItems
		$I->comment("Exiting Action Group [assertNoItems] AssertAdminCustomerNoItemsInWishlistActionGroup");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [loginOnStoreFront] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginOnStoreFront
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginOnStoreFront
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginOnStoreFront
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginOnStoreFront
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginOnStoreFront
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginOnStoreFront
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginOnStoreFrontWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginOnStoreFront
		$I->comment("Exiting Action Group [loginOnStoreFront] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [navigateToWishlist] NavigateThroughCustomerTabsActionGroup");
		$I->click("//div[@id='block-collapsible-nav']//a[text()='My Wish List']"); // stepKey: clickOnDesiredNavItemNavigateToWishlist
		$I->waitForPageLoad(60); // stepKey: clickOnDesiredNavItemNavigateToWishlistWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToWishlist
		$I->comment("Exiting Action Group [navigateToWishlist] NavigateThroughCustomerTabsActionGroup");
		$I->comment("Entering Action Group [assertNoItemsInWishlist] StorefrontAssertCustomerWishlistIsEmptyActionGroup");
		$I->dontSeeElement(".toolbar .pager"); // stepKey: checkThatPagerIsAbsentAssertNoItemsInWishlist
		$I->see("You have no items in your wish list.", ".form-wishlist-items .message.info.empty"); // stepKey: checkNoItemsMessageAssertNoItemsInWishlist
		$I->comment("Exiting Action Group [assertNoItemsInWishlist] StorefrontAssertCustomerWishlistIsEmptyActionGroup");
	}
}
