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
 * @Title("MC-14789: User should be able to use Quick Search to find a Bundle Dynamic product and add it to cart")
 * @Description("Use Quick Search to find Bundle Dynamic Product and Add to Cart<h3>Test files</h3>app/code/Magento/CatalogSearch/Test/Mftf/Test/SearchEntityResultsTest/QuickSearchAndAddToCartBundleDynamicTest.xml<br>")
 * @TestCaseId("MC-14789")
 * @group CatalogSearch
 * @group mtf_migrated
 */
class QuickSearchAndAddToCartBundleDynamicTestCest
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
		$I->createEntity("createProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Create dynamic product");
		$I->createEntity("createBundleProduct", "hook", "ApiBundleProductPriceViewRange", ["createCategory"], []); // stepKey: createBundleProduct
		$I->createEntity("bundleOption", "hook", "DropDownBundleOption", ["createBundleProduct"], []); // stepKey: bundleOption
		$createBundleLink1Fields['qty'] = "10";
		$I->createEntity("createBundleLink1", "hook", "ApiBundleLink", ["createBundleProduct", "bundleOption", "createProduct"], $createBundleLink1Fields); // stepKey: createBundleLink1
		$I->comment("Finish bundle creation");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createBundleProduct', 'id', 'hook')); // stepKey: goToProductGoToProductEditPage
		$I->comment("Exiting Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
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
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [flushCache] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushCache = $I->magentoCLI("cache:flush", 60, ""); // stepKey: flushSpecifiedCacheFlushCache
		$I->comment($flushSpecifiedCacheFlushCache);
		$I->comment("Exiting Action Group [flushCache] CliCacheFlushActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createBundleProduct", "hook"); // stepKey: deleteBundleProduct
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Search Product on Storefront"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"CatalogSearch"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function QuickSearchAndAddToCartBundleDynamicTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToFrontPage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToFrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToFrontPage
		$I->comment("Exiting Action Group [goToFrontPage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [searchStorefront] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", $I->retrieveEntityField('createBundleProduct', 'name', 'test')); // stepKey: fillInputSearchStorefront
		$I->submitForm("#search", []); // stepKey: submitQuickSearchSearchStorefront
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlSearchStorefront
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeySearchStorefront
		$I->seeInTitle("Search results for: '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "'"); // stepKey: assertQuickSearchTitleSearchStorefront
		$I->see("Search results for: '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "'", ".page-title span"); // stepKey: assertQuickSearchNameSearchStorefront
		$I->comment("Exiting Action Group [searchStorefront] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [openAndCheckProduct] StorefrontOpenProductFromQuickSearchActionGroup");
		$I->scrollTo("//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]]"); // stepKey: scrollToProductOpenAndCheckProduct
		$I->click("//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]]"); // stepKey: openProductOpenAndCheckProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductLoadOpenAndCheckProduct
		$I->seeInCurrentUrl($I->retrieveEntityField('createBundleProduct', 'custom_attributes[url_key]', 'test')); // stepKey: checkUrlOpenAndCheckProduct
		$I->see($I->retrieveEntityField('createBundleProduct', 'name', 'test'), ".base"); // stepKey: checkNameOpenAndCheckProduct
		$I->comment("Exiting Action Group [openAndCheckProduct] StorefrontOpenProductFromQuickSearchActionGroup");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddBundleProductFromProductToCartActionGroup");
		$I->click("#bundle-slide"); // stepKey: clickCustomizeAndAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: clickCustomizeAndAddToCartAddProductToCartWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: clickAddBundleProductToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: clickAddBundleProductToCartAddProductToCartWaitForPageLoad
		$I->waitForElementVisible("//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']", 30); // stepKey: waitProductCountAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddBundleProductFromProductToCartActionGroup");
	}
}
