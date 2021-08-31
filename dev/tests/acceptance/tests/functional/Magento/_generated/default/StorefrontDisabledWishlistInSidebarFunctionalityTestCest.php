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
 * @Title("MC-42429: Wishlist should not be displayed in the sidebar if 'Show in Sidebar' option is set to 'No'")
 * @Description("Customer should not see wishlist block in the sidebar if 'Show in Sidebar' option is set to 'No'<h3>Test files</h3>app/code/Magento/Wishlist/Test/Mftf/Test/StorefrontDisabledWishlistInSidebarFunctionalityTest.xml<br>")
 * @TestCaseId("MC-42429")
 * @group wishlist
 * @group configuration
 */
class StorefrontDisabledWishlistInSidebarFunctionalityTestCest
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
		$disableWishlistInSidebar = $I->magentoCLI("config:set wishlist/general/show_in_sidebar 0", 60); // stepKey: disableWishlistInSidebar
		$I->comment($disableWishlistInSidebar);
		$cleanCache = $I->magentoCLI("cache:clean config full_page block_html", 60); // stepKey: cleanCache
		$I->comment($cleanCache);
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, ""); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$enableWishlistInSidebar = $I->magentoCLI("config:set wishlist/general/show_in_sidebar 1", 60); // stepKey: enableWishlistInSidebar
		$I->comment($enableWishlistInSidebar);
		$cleanCache = $I->magentoCLI("cache:clean config full_page block_html", 60); // stepKey: cleanCache
		$I->comment($cleanCache);
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, ""); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
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
	 * @Stories({"'Show In Sidebar' Wishlist Functionality"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontDisabledWishlistInSidebarFunctionalityTest(AcceptanceTester $I)
	{
		$I->comment("Assert the Wishlist is not visible in sidebar for logged in customer");
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
		$I->comment("Entering Action Group [assertWishlistFunctionalityIsEnabledForCustomer] StorefrontAssertCustomerSidebarItemIsPresentActionGroup");
		$I->see("My Wish List", "//div[@id='block-collapsible-nav']//a[text()='My Wish List']"); // stepKey: seeElementAssertWishlistFunctionalityIsEnabledForCustomer
		$I->waitForPageLoad(60); // stepKey: seeElementAssertWishlistFunctionalityIsEnabledForCustomerWaitForPageLoad
		$I->comment("Exiting Action Group [assertWishlistFunctionalityIsEnabledForCustomer] StorefrontAssertCustomerSidebarItemIsPresentActionGroup");
		$I->comment("Check the category page");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToCategoryPageAsLoggedInCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadForLoggedInCustomer
		$I->comment("Entering Action Group [assertWishlistBlockIsNotVisibleOnCategoryPageForLoggedInCustomer] StorefrontAssertWishlistBlockIsNotVisibleOnSidebarActionGroup");
		$I->comment("Assert sidebar itself is present on the page");
		$I->seeElementInDOM("#maincontent .sidebar.sidebar-additional"); // stepKey: assertSidebarIsVisibleAssertWishlistBlockIsNotVisibleOnCategoryPageForLoggedInCustomer
		$I->comment("Assert wishlist block is not present in the sidebar");
		$I->dontSeeElementInDOM("div.sidebar.sidebar-additional > div.block.block-wishlist"); // stepKey: assertWishlistBlockIsNotVisibleOnSidebarAssertWishlistBlockIsNotVisibleOnCategoryPageForLoggedInCustomer
		$I->comment("Exiting Action Group [assertWishlistBlockIsNotVisibleOnCategoryPageForLoggedInCustomer] StorefrontAssertWishlistBlockIsNotVisibleOnSidebarActionGroup");
		$I->comment("Check the search result page");
		$I->comment("Entering Action Group [searchProductOnStorefrontForLoggedInCustomer] StorefrontCheckQuickSearchActionGroup");
		$I->submitForm("#search_mini_form", ['q' => $I->retrieveEntityField('createProduct', 'name', 'test')]); // stepKey: fillQuickSearchSearchProductOnStorefrontForLoggedInCustomer
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlSearchProductOnStorefrontForLoggedInCustomer
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeySearchProductOnStorefrontForLoggedInCustomer
		$I->seeInTitle("Search results for: '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "'"); // stepKey: assertQuickSearchTitleSearchProductOnStorefrontForLoggedInCustomer
		$I->see("Search results for: '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "'", ".page-title span"); // stepKey: assertQuickSearchNameSearchProductOnStorefrontForLoggedInCustomer
		$I->comment("Exiting Action Group [searchProductOnStorefrontForLoggedInCustomer] StorefrontCheckQuickSearchActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForSearchPageToLoadForLoggedInCustomer
		$I->comment("Entering Action Group [assertWishlistBlockIsNotVisibleOnSearchResultPageForLoggedInCustomer] StorefrontAssertWishlistBlockIsNotVisibleOnSidebarActionGroup");
		$I->comment("Assert sidebar itself is present on the page");
		$I->seeElementInDOM("#maincontent .sidebar.sidebar-additional"); // stepKey: assertSidebarIsVisibleAssertWishlistBlockIsNotVisibleOnSearchResultPageForLoggedInCustomer
		$I->comment("Assert wishlist block is not present in the sidebar");
		$I->dontSeeElementInDOM("div.sidebar.sidebar-additional > div.block.block-wishlist"); // stepKey: assertWishlistBlockIsNotVisibleOnSidebarAssertWishlistBlockIsNotVisibleOnSearchResultPageForLoggedInCustomer
		$I->comment("Exiting Action Group [assertWishlistBlockIsNotVisibleOnSearchResultPageForLoggedInCustomer] StorefrontAssertWishlistBlockIsNotVisibleOnSidebarActionGroup");
		$I->comment("Assert the Wishlist is not visible in sidebar for guest customer");
		$I->comment("Entering Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomer
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomer
		$I->comment("Exiting Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->comment("Check the category page");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToCategoryPageAsGuest
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadForGuest
		$I->comment("Entering Action Group [assertWishlistBlockIsNotVisibleOnCategoryPageForGuest] StorefrontAssertWishlistBlockIsNotVisibleOnSidebarActionGroup");
		$I->comment("Assert sidebar itself is present on the page");
		$I->seeElementInDOM("#maincontent .sidebar.sidebar-additional"); // stepKey: assertSidebarIsVisibleAssertWishlistBlockIsNotVisibleOnCategoryPageForGuest
		$I->comment("Assert wishlist block is not present in the sidebar");
		$I->dontSeeElementInDOM("div.sidebar.sidebar-additional > div.block.block-wishlist"); // stepKey: assertWishlistBlockIsNotVisibleOnSidebarAssertWishlistBlockIsNotVisibleOnCategoryPageForGuest
		$I->comment("Exiting Action Group [assertWishlistBlockIsNotVisibleOnCategoryPageForGuest] StorefrontAssertWishlistBlockIsNotVisibleOnSidebarActionGroup");
		$I->comment("Check the search result page");
		$I->comment("Entering Action Group [searchProductOnStorefrontForGuest] StorefrontCheckQuickSearchActionGroup");
		$I->submitForm("#search_mini_form", ['q' => $I->retrieveEntityField('createProduct', 'name', 'test')]); // stepKey: fillQuickSearchSearchProductOnStorefrontForGuest
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlSearchProductOnStorefrontForGuest
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeySearchProductOnStorefrontForGuest
		$I->seeInTitle("Search results for: '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "'"); // stepKey: assertQuickSearchTitleSearchProductOnStorefrontForGuest
		$I->see("Search results for: '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "'", ".page-title span"); // stepKey: assertQuickSearchNameSearchProductOnStorefrontForGuest
		$I->comment("Exiting Action Group [searchProductOnStorefrontForGuest] StorefrontCheckQuickSearchActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForSearchPageToLoadForGuest
		$I->comment("Entering Action Group [assertWishlistBlockIsNotVisibleOnSearchResultPageForGuest] StorefrontAssertWishlistBlockIsNotVisibleOnSidebarActionGroup");
		$I->comment("Assert sidebar itself is present on the page");
		$I->seeElementInDOM("#maincontent .sidebar.sidebar-additional"); // stepKey: assertSidebarIsVisibleAssertWishlistBlockIsNotVisibleOnSearchResultPageForGuest
		$I->comment("Assert wishlist block is not present in the sidebar");
		$I->dontSeeElementInDOM("div.sidebar.sidebar-additional > div.block.block-wishlist"); // stepKey: assertWishlistBlockIsNotVisibleOnSidebarAssertWishlistBlockIsNotVisibleOnSearchResultPageForGuest
		$I->comment("Exiting Action Group [assertWishlistBlockIsNotVisibleOnSearchResultPageForGuest] StorefrontAssertWishlistBlockIsNotVisibleOnSidebarActionGroup");
	}
}
