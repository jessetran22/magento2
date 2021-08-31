<?php
namespace Magento\AcceptanceTest\_SearchEngineElasticsearchSuite\Backend;

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
 * @Title("MC-6092: Storefront Shop By collapsible button works in a mobile theme")
 * @Description("Storefront Shop By collapsible button should work in a mobile theme<h3>Test files</h3>app/code/Magento/LayeredNavigation/Test/Mftf/Test/ShopByButtonInMobileTest.xml<br>")
 * @TestCaseId("MC-6092")
 * @group LayeredNavigation
 * @group SearchEngineElasticsearch
 */
class ShopByButtonInMobileTestCest
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
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("attribute", "hook", "productDropDownAttribute", [], []); // stepKey: attribute
		$I->createEntity("option1", "hook", "productAttributeOption1", ["attribute"], []); // stepKey: option1
		$I->createEntity("attributeSet", "hook", "AddToDefaultSet", ["attribute"], []); // stepKey: attributeSet
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct1
		$I->createEntity("simpleProduct2", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct2
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
		$I->deleteEntity("attribute", "hook"); // stepKey: deleteAttribute
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->resizeWindow(1280, 1024); // stepKey: resizeWindowToDesktop
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
	 * @Features({"LayeredNavigation"})
	 * @Stories({"Storefront Shop By collapsible button in mobile themes"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function ShopByButtonInMobileTest(AcceptanceTester $I)
	{
		$I->comment("Go to default attribute set edit page and add the product attribute to the set");
		$I->comment("Go to default attribute set edit page and add the product attribute to the set");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/edit/id/4/"); // stepKey: onAttributeSetEdit
		$I->dragAndDrop("//span[text()='" . $I->retrieveEntityField('attribute', 'attribute[attribute_code]', 'test') . "']", "//span[text()='Product Details']"); // stepKey: assignTestAttributes
		$I->click("button.save-attribute-set"); // stepKey: clickAttributeSetSave
		$I->waitForPageLoad(30); // stepKey: clickAttributeSetSaveWaitForPageLoad
		$I->comment("Go to simple product edit page and set the product attribute to a value");
		$I->comment("Go to simple product edit page and set the product attribute to a value");
		$I->comment("Entering Action Group [goToEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('simpleProduct1', 'id', 'test')); // stepKey: goToProductGoToEditPage
		$I->comment("Exiting Action Group [goToEditPage] AdminProductPageOpenByIdActionGroup");
		$I->selectOption("//select[@name='product[" . $I->retrieveEntityField('attribute', 'attribute[attribute_code]', 'test') . "]']", "option1"); // stepKey: selectAttribute
		$I->comment("Entering Action Group [saveSimpleProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveSimpleProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveSimpleProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveSimpleProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveSimpleProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveSimpleProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveSimpleProduct
		$I->comment("Exiting Action Group [saveSimpleProduct] SaveProductFormActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Check storefront mobile view for shop by button is functioning as expected");
		$I->comment("Check storefront mobile view for shop by button is functioning as expected");
		$I->comment("Entering Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage
		$I->comment("Exiting Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->submitForm("#search_mini_form", ['q' => 'Simple']); // stepKey: fillSearchBar
		$I->resizeWindow(600, 800); // stepKey: resizeWindow
		$I->waitForPageLoad(30); // stepKey: waitForHomePageToLoad2
		$I->seeElement("//div[contains(@class, 'filter-title')]/strong[contains(text(), 'Shop By')]"); // stepKey: seeShopByButton
		$I->click("//div[contains(@class, 'filter-title')]/strong[contains(text(), 'Shop By')]"); // stepKey: clickShopByButton
		$I->seeElement("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('attribute', 'attribute[default_label]', 'test') . "')]"); // stepKey: seeShopByOption
	}
}
