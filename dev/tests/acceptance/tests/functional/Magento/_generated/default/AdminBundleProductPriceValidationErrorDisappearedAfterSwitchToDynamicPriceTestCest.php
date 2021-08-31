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
 * @Title("MC-40309: Assert error message for price field")
 * @Description("Verify error message for price field is not visible when toggle Dynamic Price is disabled<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/AdminBundleProductPriceValidationErrorDisappearedAfterSwitchToDynamicPriceTest.xml<br>")
 * @TestCaseId("MC-40309")
 * @group bundle
 */
class AdminBundleProductPriceValidationErrorDisappearedAfterSwitchToDynamicPriceTestCest
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
	 * @Features({"Bundle"})
	 * @Stories({"Create/Edit bundle product in Admin"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminBundleProductPriceValidationErrorDisappearedAfterSwitchToDynamicPriceTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openNewBundleProductPage] AdminOpenNewProductFormPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/bundle/"); // stepKey: openProductNewPageOpenNewBundleProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenNewBundleProductPage
		$I->comment("Exiting Action Group [openNewBundleProductPage] AdminOpenNewProductFormPageActionGroup");
		$I->comment("Entering Action Group [disableDynamicPrice] AdminToggleSwitchDynamicPriceOnProductEditPageActionGroup");
		$I->waitForElementVisible("//div[@data-index='price_type']//div[@data-role='switcher']", 30); // stepKey: waitForToggleDynamicPriceDisableDynamicPrice
		$I->checkOption("//div[@data-index='price_type']//div[@data-role='switcher']"); // stepKey: switchDynamicPriceToggleDisableDynamicPrice
		$I->comment("Exiting Action Group [disableDynamicPrice] AdminToggleSwitchDynamicPriceOnProductEditPageActionGroup");
		$I->comment("Entering Action Group [fillProductPriceField] AdminFillProductPriceFieldAndPressEnterOnProductEditPageActionGroup");
		$I->waitForElementVisible(".admin__field[data-index=price] input", 30); // stepKey: waitForPriceFieldFillProductPriceField
		$I->fillField(".admin__field[data-index=price] input", "test"); // stepKey: fillPriceFieldFillProductPriceField
		$I->pressKey(".admin__field[data-index=price] input", \Facebook\WebDriver\WebDriverKeys::ENTER); // stepKey: pressEnterButtonFillProductPriceField
		$I->comment("Exiting Action Group [fillProductPriceField] AdminFillProductPriceFieldAndPressEnterOnProductEditPageActionGroup");
		$I->comment("Entering Action Group [assertVisibleError] AssertAdminValidationErrorAppearedForPriceFieldOnProductEditPageActionGroup");
		$I->waitForElementVisible("//input[@name='product[price]']/parent::div/parent::div/label[@class='admin__field-error']", 30); // stepKey: waitForValidationErrorAssertVisibleError
		$I->see("Please enter a number 0 or greater in this field.", "//input[@name='product[price]']/parent::div/parent::div/label[@class='admin__field-error']"); // stepKey: seeElementValidationErrorAssertVisibleError
		$I->comment("Exiting Action Group [assertVisibleError] AssertAdminValidationErrorAppearedForPriceFieldOnProductEditPageActionGroup");
		$I->comment("Entering Action Group [enableDynamicPrice] AdminToggleSwitchDynamicPriceOnProductEditPageActionGroup");
		$I->waitForElementVisible("//div[@data-index='price_type']//div[@data-role='switcher']", 30); // stepKey: waitForToggleDynamicPriceEnableDynamicPrice
		$I->checkOption("//div[@data-index='price_type']//div[@data-role='switcher']"); // stepKey: switchDynamicPriceToggleEnableDynamicPrice
		$I->comment("Exiting Action Group [enableDynamicPrice] AdminToggleSwitchDynamicPriceOnProductEditPageActionGroup");
		$I->comment("Entering Action Group [assertNotVisibleError] AssertAdminNoValidationErrorForPriceFieldOnProductEditPageActionGroup");
		$I->dontSeeElement("//input[@name='product[price]']/parent::div/parent::div/label[@class='admin__field-error']"); // stepKey: dontSeeValidationErrorAssertNotVisibleError
		$I->comment("Exiting Action Group [assertNotVisibleError] AssertAdminNoValidationErrorForPriceFieldOnProductEditPageActionGroup");
	}
}
