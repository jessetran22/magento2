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
 * @Title("[NO TESTCASEID]: Admin can not able create a CMS block with marginal space in identifier field")
 * @Description("Admin can not able create a CMS block with marginal space in identifier field<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminCreateCmsBlockWithMarginalSpaceTest.xml<br>")
 * @group Cms
 */
class AdminCreateCmsBlockWithMarginalSpaceTestCest
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
		$I->comment("Entering Action Group [loginGetFromGeneralFile] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginGetFromGeneralFile
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginGetFromGeneralFile
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginGetFromGeneralFile
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginGetFromGeneralFile
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginGetFromGeneralFileWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginGetFromGeneralFile
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginGetFromGeneralFile
		$I->comment("Exiting Action Group [loginGetFromGeneralFile] AdminLoginActionGroup");
		$I->comment("Entering Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
		$disableWYSIWYGDisableWYSIWYG = $I->magentoCLI("config:set cms/wysiwyg/enabled disabled", 60); // stepKey: disableWYSIWYGDisableWYSIWYG
		$I->comment($disableWYSIWYGDisableWYSIWYG);
		$I->comment("Exiting Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Features({"Cms"})
	 * @Stories({"CMS Block Identifier with marginal space"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCmsBlockWithMarginalSpaceTest(AcceptanceTester $I)
	{
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/new"); // stepKey: amOnBlocksCreationForm
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1
		$I->comment("Verify Save&Duplicate button and Save&Close button");
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitBtn1
		$I->waitForPageLoad(10); // stepKey: expandSplitBtn1WaitForPageLoad
		$I->see("Save & Duplicate", "#save_and_duplicate"); // stepKey: seeSaveAndDuplicate
		$I->waitForPageLoad(10); // stepKey: seeSaveAndDuplicateWaitForPageLoad
		$I->see("Save & Close", "#save_and_close"); // stepKey: seeSaveAndClose
		$I->waitForPageLoad(10); // stepKey: seeSaveAndCloseWaitForPageLoad
		$I->comment("Create new CMS Block page with marginal space in identifier field");
		$I->comment("Entering Action Group [FillOutBlockContent] AdminFillCmsBlockFormActionGroup");
		$I->fillField("input[name=title]", "Default Block"); // stepKey: fillFieldTitle1FillOutBlockContent
		$I->fillField("input[name=identifier]", " block "); // stepKey: fillFieldIdentifierFillOutBlockContent
		$I->selectOption("select[name=store_id]", "All Store View"); // stepKey: selectAllStoreViewFillOutBlockContent
		$I->fillField("textarea", "Here is a block test. Yeah!"); // stepKey: fillContentFieldFillOutBlockContent
		$I->comment("Exiting Action Group [FillOutBlockContent] AdminFillCmsBlockFormActionGroup");
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitBtn2
		$I->waitForPageLoad(10); // stepKey: expandSplitBtn2WaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clicksaveAndClose
		$I->waitForPageLoad(10); // stepKey: clicksaveAndCloseWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3
		$I->see("No marginal white space please"); // stepKey: seeNoMarginalSpaceMsgOnIdentifierField
	}
}
