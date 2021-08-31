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
 * @Title("MC-35200: Wishlist Functionality is disabled in system configurations and not visible on FE")
 * @Description("Customer should not see wishlist functionality if it's disabled<h3>Test files</h3>app/code/Magento/Wishlist/Test/Mftf/Test/StorefrontDisabledCustomerWishlistFunctionalityTest.xml<br>")
 * @TestCaseId("MC-35200")
 * @group wishlist
 * @group configuration
 */
class StorefrontDisabledCustomerWishlistFunctionalityTestCest
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
		$disableWishlist = $I->magentoCLI("config:set wishlist/general/active 0", 60); // stepKey: disableWishlist
		$I->comment($disableWishlist);
		$cleanCache = $I->magentoCLI("cache:clean config", 60); // stepKey: cleanCache
		$I->comment($cleanCache);
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$runCronIndexer = $I->magentoCLI("cron:run --group=index", 60); // stepKey: runCronIndexer
		$I->comment($runCronIndexer);
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$enableWishlist = $I->magentoCLI("config:set wishlist/general/active 1", 60); // stepKey: enableWishlist
		$I->comment($enableWishlist);
		$cacheClean = $I->magentoCLI("cache:clean config", 60); // stepKey: cacheClean
		$I->comment($cacheClean);
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
	 * @Stories({"Disabled Wishlist Functionality"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontDisabledCustomerWishlistFunctionalityTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [assertItemIsNotPresent] StorefrontAssertCustomerSidebarItemIsNotPresentActionGroup");
		$I->dontSee("My Wish List", "//div[@id='block-collapsible-nav']//a[text()='My Wish List']"); // stepKey: dontSeeElementAssertItemIsNotPresent
		$I->waitForPageLoad(60); // stepKey: dontSeeElementAssertItemIsNotPresentWaitForPageLoad
		$I->comment("Exiting Action Group [assertItemIsNotPresent] StorefrontAssertCustomerSidebarItemIsNotPresentActionGroup");
		$I->comment("Entering Action Group [openProductPage] OpenStoreFrontProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] OpenStoreFrontProductPageActionGroup");
		$I->comment("Entering Action Group [assertButtonIsAbsent] StorefrontAssertProductPageAddToWishlistButtonIsNotPresentActionGroup");
		$I->dontSee("Add to Wish List", "//a[@class='action towishlist']"); // stepKey: dontSeeElementAssertButtonIsAbsent
		$I->waitForPageLoad(30); // stepKey: dontSeeElementAssertButtonIsAbsentWaitForPageLoad
		$I->comment("Exiting Action Group [assertButtonIsAbsent] StorefrontAssertProductPageAddToWishlistButtonIsNotPresentActionGroup");
	}
}
