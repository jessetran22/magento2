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
 * @Title("MAGETWO-95797: Category should not be saved once layered navigation price step field is left empty")
 * @Description("Once the Config setting is unchecked Category should not be saved with layered navigation price field left empty<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateCategoryTest/AdminCategoryFormDisplaySettingsUIValidationTest.xml<br>")
 * @TestCaseId("MAGETWO-95797")
 * @group category
 */
class AdminCategoryFormDisplaySettingsUIValidationTestCest
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
	 * @Features({"Catalog"})
	 * @Stories({"Default layout configuration MAGETWO-88793"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCategoryFormDisplaySettingsUIValidationTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageNavigateToCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadNavigateToCategoryPage
		$I->comment("Exiting Action Group [navigateToCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategory
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryWaitForPageLoad
		$I->fillField("input[name='name']", "SimpleSubCategory" . msq("SimpleSubCategory")); // stepKey: enterCategoryName
		$I->click("//strong[@class='admin__collapsible-title']//span[text()='Display Settings']"); // stepKey: clickOnDisplaySettingsTab
		$I->waitForElementVisible("input[name='use_config[filter_price_range]']", 30); // stepKey: wait
		$I->scrollTo("input[name='filter_price_range']"); // stepKey: scrollToLayeredNavigationField
		$I->uncheckOption("input[name='use_config[filter_price_range]']"); // stepKey: uncheckConfigSetting
		$I->click(".page-actions-inner #save"); // stepKey: saveCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryWaitForPageLoad
		$I->see("This is a required field.", ".admin__field-error[data-bind='attr: {for: uid}, text: error']"); // stepKey: seeErrorMessage
		$I->comment("Verify that the Layered navigation price step field has the required indicator");
		$I->comment("Check if Layered navigation price field has required indicator icon");
		$getRequiredFieldIndicator = $I->executeJS(" return window.getComputedStyle(document.querySelector('._required[data-index=filter_price_range]>.admin__field-label span'), ':after').getPropertyValue('content');"); // stepKey: getRequiredFieldIndicator
		$I->assertEquals("\"*\"", $getRequiredFieldIndicator, "pass"); // stepKey: assertRequiredFieldIndicator1
	}
}
